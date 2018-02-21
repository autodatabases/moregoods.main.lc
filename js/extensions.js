(function($Object, $Function, privates, cls, superclass) {'use strict';
  function Event() {
    var privateObj = $Object.create(cls.prototype);
    $Function.apply(cls, privateObj, arguments);
    privateObj.wrapper = this;
    privates(this).impl = privateObj;
  };
  if (superclass) {
    Event.prototype = Object.create(superclass.prototype);
  }
  return Event;
})
//----------------------------------------------------------------------
(function($Object, $Function, privates, cls, superclass) {'use strict';
  function Port() {
    var privateObj = $Object.create(cls.prototype);
    $Function.apply(cls, privateObj, arguments);
    privateObj.wrapper = this;
    privates(this).impl = privateObj;
  };
  if (superclass) {
    Port.prototype = Object.create(superclass.prototype);
  }
  return Port;
})
//----------------------------------------------------------------------


(function(define, require, requireNative, requireAsync, exports, console, privates,$Array, $Function, $JSON, $Object, $RegExp, $String, $Error) {'use strict';// Copyright 2014 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.

  var exceptionHandler = require('uncaught_exception_handler');
  var eventNatives = requireNative('event_natives');
  var logging = requireNative('logging');
  var schemaRegistry = requireNative('schema_registry');
  var sendRequest = require('sendRequest').sendRequest;
  var utils = require('utils');
  var validate = require('schemaUtils').validate;

  // Schemas for the rule-style functions on the events API that
  // only need to be generated occasionally, so populate them lazily.
  var ruleFunctionSchemas = {
    // These values are set lazily:
    // addRules: {},
    // getRules: {},
    // removeRules: {}
  };

  // This function ensures that |ruleFunctionSchemas| is populated.
  function ensureRuleSchemasLoaded() {
    if (ruleFunctionSchemas.addRules)
      return;
    var eventsSchema = schemaRegistry.GetSchema("events");
    var eventType = utils.lookup(eventsSchema.types, 'id', 'events.Event');

    ruleFunctionSchemas.addRules =
        utils.lookup(eventType.functions, 'name', 'addRules');
    ruleFunctionSchemas.getRules =
        utils.lookup(eventType.functions, 'name', 'getRules');
    ruleFunctionSchemas.removeRules =
        utils.lookup(eventType.functions, 'name', 'removeRules');
  }

  // A map of event names to the event object that is registered to that name.
  var attachedNamedEvents = {};

  // A map of functions that massage event arguments before they are dispatched.
  // Key is event name, value is function.
  var eventArgumentMassagers = {};

  // An attachment strategy for events that aren't attached to the browser.
  // This applies to events with the "unmanaged" option and events without
  // names.
  var NullAttachmentStrategy = function(event) {
    this.event_ = event;
  };
  NullAttachmentStrategy.prototype.onAddedListener =
      function(listener) {
  };
  NullAttachmentStrategy.prototype.onRemovedListener =
      function(listener) {
  };
  NullAttachmentStrategy.prototype.detach = function(manual) {
  };
  NullAttachmentStrategy.prototype.getListenersByIDs = function(ids) {
    // |ids| is for filtered events only.
    return this.event_.listeners;
  };

  // Handles adding/removing/dispatching listeners for unfiltered events.
  var UnfilteredAttachmentStrategy = function(event) {
    this.event_ = event;
  };

  UnfilteredAttachmentStrategy.prototype.onAddedListener =
      function(listener) {
    // Only attach / detach on the first / last listener removed.
    if (this.event_.listeners.length == 0)
      eventNatives.AttachEvent(this.event_.eventName);
  };

  UnfilteredAttachmentStrategy.prototype.onRemovedListener =
      function(listener) {
    if (this.event_.listeners.length == 0)
      this.detach(true);
  };

  UnfilteredAttachmentStrategy.prototype.detach = function(manual) {
    eventNatives.DetachEvent(this.event_.eventName, manual);
  };

  UnfilteredAttachmentStrategy.prototype.getListenersByIDs = function(ids) {
    // |ids| is for filtered events only.
    return this.event_.listeners;
  };

  var FilteredAttachmentStrategy = function(event) {
    this.event_ = event;
    this.listenerMap_ = {};
  };

  FilteredAttachmentStrategy.idToEventMap = {};

  FilteredAttachmentStrategy.prototype.onAddedListener = function(listener) {
    var id = eventNatives.AttachFilteredEvent(this.event_.eventName,
                                              listener.filters || {});
    if (id == -1)
      throw new Error("Can't add listener");
    listener.id = id;
    this.listenerMap_[id] = listener;
    FilteredAttachmentStrategy.idToEventMap[id] = this.event_;
  };

  FilteredAttachmentStrategy.prototype.onRemovedListener = function(listener) {
    this.detachListener(listener, true);
  };

  FilteredAttachmentStrategy.prototype.detachListener =
      function(listener, manual) {
    if (listener.id == undefined)
      throw new Error("listener.id undefined - '" + listener + "'");
    var id = listener.id;
    delete this.listenerMap_[id];
    delete FilteredAttachmentStrategy.idToEventMap[id];
    eventNatives.DetachFilteredEvent(id, manual);
  };

  FilteredAttachmentStrategy.prototype.detach = function(manual) {
    for (var i in this.listenerMap_)
      this.detachListener(this.listenerMap_[i], manual);
  };

  FilteredAttachmentStrategy.prototype.getListenersByIDs = function(ids) {
    var result = [];
    for (var i = 0; i < ids.length; i++)
      $Array.push(result, this.listenerMap_[ids[i]]);
    return result;
  };

  function parseEventOptions(opt_eventOptions) {
    function merge(dest, src) {
      for (var k in src) {
        if (!$Object.hasOwnProperty(dest, k)) {
          dest[k] = src[k];
        }
      }
    }

    var options = opt_eventOptions || {};
    merge(options, {
      // Event supports adding listeners with filters ("filtered events"), for
      // example as used in the webNavigation API.
      //
      // event.addListener(listener, [filter1, filter2]);
      supportsFilters: false,

      // Events supports vanilla events. Most APIs use these.
      //
      // event.addListener(listener);
      supportsListeners: true,

      // Event supports adding rules ("declarative events") rather than
      // listeners, for example as used in the declarativeWebRequest API.
      //
      // event.addRules([rule1, rule2]);
      supportsRules: false,

      // Event is unmanaged in that the browser has no knowledge of its
      // existence; it's never invoked, doesn't keep the renderer alive, and
      // the bindings system has no knowledge of it.
      //
      // Both events created by user code (new chrome.Event()) and messaging
      // events are unmanaged, though in the latter case the browser *does*
      // interact indirectly with them via IPCs written by hand.
      unmanaged: false,
    });
    return options;
  };

  // Event object.  If opt_eventName is provided, this object represents
  // the unique instance of that named event, and dispatching an event
  // with that name will route through this object's listeners. Note that
  // opt_eventName is required for events that support rules.
  //
  // Example:
  //   var Event = require('event_bindings').Event;
  //   chrome.tabs.onChanged = new Event("tab-changed");
  //   chrome.tabs.onChanged.addListener(function(data) { alert(data); });
  //   Event.dispatch("tab-changed", "hi");
  // will result in an alert dialog that says 'hi'.
  //
  // If opt_eventOptions exists, it is a dictionary that contains the boolean
  // entries "supportsListeners" and "supportsRules".
  // If opt_webViewInstanceId exists, it is an integer uniquely identifying a
  // <webview> tag within the embedder. If it does not exist, then this is an
  // extension event rather than a <webview> event.
  var EventImpl = function(opt_eventName, opt_argSchemas, opt_eventOptions,
                           opt_webViewInstanceId) {
    this.eventName = opt_eventName;
    this.argSchemas = opt_argSchemas;
    this.listeners = [];
    this.eventOptions = parseEventOptions(opt_eventOptions);
    this.webViewInstanceId = opt_webViewInstanceId || 0;

    if (!this.eventName) {
      if (this.eventOptions.supportsRules)
        throw new Error("Events that support rules require an event name.");
      // Events without names cannot be managed by the browser by definition
      // (the browser has no way of identifying them).
      this.eventOptions.unmanaged = true;
    }

    // Track whether the event has been destroyed to help track down the cause
    // of http://crbug.com/258526.
    // This variable will eventually hold the stack trace of the destroy call.
    // TODO(kalman): Delete this and replace with more sound logic that catches
    // when events are used without being *attached*.
    this.destroyed = null;

    if (this.eventOptions.unmanaged)
      this.attachmentStrategy = new NullAttachmentStrategy(this);
    else if (this.eventOptions.supportsFilters)
      this.attachmentStrategy = new FilteredAttachmentStrategy(this);
    else
      this.attachmentStrategy = new UnfilteredAttachmentStrategy(this);
  };

  // callback is a function(args, dispatch). args are the args we receive from
  // dispatchEvent(), and dispatch is a function(args) that dispatches args to
  // its listeners.
  function registerArgumentMassager(name, callback) {
    if (eventArgumentMassagers[name])
      throw new Error("Massager already registered for event: " + name);
    eventArgumentMassagers[name] = callback;
  }

  // Dispatches a named event with the given argument array. The args array is
  // the list of arguments that will be sent to the event callback.
  function dispatchEvent(name, args, filteringInfo) {
    var listenerIDs = [];

    if (filteringInfo)
      listenerIDs = eventNatives.MatchAgainstEventFilter(name, filteringInfo);

    var event = attachedNamedEvents[name];
    if (!event)
      return;

    var dispatchArgs = function(args) {
      var result = event.dispatch_(args, listenerIDs);
      if (result)
        logging.DCHECK(!result.validationErrors, result.validationErrors);
      return result;
    };

    if (eventArgumentMassagers[name])
      eventArgumentMassagers[name](args, dispatchArgs);
    else
      dispatchArgs(args);
  }

  // Registers a callback to be called when this event is dispatched.
  EventImpl.prototype.addListener = function(cb, filters) {
    if (!this.eventOptions.supportsListeners)
      throw new Error("This event does not support listeners.");
    if (this.eventOptions.maxListeners &&
        this.getListenerCount_() >= this.eventOptions.maxListeners) {
      throw new Error("Too many listeners for " + this.eventName);
    }
    if (filters) {
      if (!this.eventOptions.supportsFilters)
        throw new Error("This event does not support filters.");
      if (filters.url && !(filters.url instanceof Array))
        throw new Error("filters.url should be an array.");
      if (filters.serviceType &&
          !(typeof filters.serviceType === 'string')) {
        throw new Error("filters.serviceType should be a string.")
      }
    }
    var listener = {callback: cb, filters: filters};
    this.attach_(listener);
    $Array.push(this.listeners, listener);
  };

  EventImpl.prototype.attach_ = function(listener) {
    this.attachmentStrategy.onAddedListener(listener);

    if (this.listeners.length == 0) {
      if (this.eventName) {
        if (attachedNamedEvents[this.eventName]) {
          throw new Error("Event '" + this.eventName +
                          "' is already attached.");
        }
        attachedNamedEvents[this.eventName] = this;
      }
    }
  };

  // Unregisters a callback.
  EventImpl.prototype.removeListener = function(cb) {
    if (!this.eventOptions.supportsListeners)
      throw new Error("This event does not support listeners.");

    var idx = this.findListener_(cb);
    if (idx == -1)
      return;

    var removedListener = $Array.splice(this.listeners, idx, 1)[0];
    this.attachmentStrategy.onRemovedListener(removedListener);

    if (this.listeners.length == 0) {
      if (this.eventName) {
        if (!attachedNamedEvents[this.eventName]) {
          throw new Error(
              "Event '" + this.eventName + "' is not attached.");
        }
        delete attachedNamedEvents[this.eventName];
      }
    }
  };

  // Test if the given callback is registered for this event.
  EventImpl.prototype.hasListener = function(cb) {
    if (!this.eventOptions.supportsListeners)
      throw new Error("This event does not support listeners.");
    return this.findListener_(cb) > -1;
  };

  // Test if any callbacks are registered for this event.
  EventImpl.prototype.hasListeners = function() {
    return this.getListenerCount_() > 0;
  };

  // Returns the number of listeners on this event.
  EventImpl.prototype.getListenerCount_ = function() {
    if (!this.eventOptions.supportsListeners)
      throw new Error("This event does not support listeners.");
    return this.listeners.length;
  };

  // Returns the index of the given callback if registered, or -1 if not
  // found.
  EventImpl.prototype.findListener_ = function(cb) {
    for (var i = 0; i < this.listeners.length; i++) {
      if (this.listeners[i].callback == cb) {
        return i;
      }
    }

    return -1;
  };

  EventImpl.prototype.dispatch_ = function(args, listenerIDs) {
    if (this.destroyed) {
      throw new Error(this.eventName + ' was already destroyed at: ' +
                      this.destroyed);
    }
    if (!this.eventOptions.supportsListeners)
      throw new Error("This event does not support listeners.");

    if (this.argSchemas && logging.DCHECK_IS_ON()) {
      try {
        validate(args, this.argSchemas);
      } catch (e) {
        e.message += ' in ' + this.eventName;
        throw e;
      }
    }

    // Make a copy of the listeners in case the listener list is modified
    // while dispatching the event.
    var listeners = $Array.slice(
        this.attachmentStrategy.getListenersByIDs(listenerIDs));

    var results = [];
    for (var i = 0; i < listeners.length; i++) {
      try {
        var result = this.wrapper.dispatchToListener(listeners[i].callback,
                                                     args);
        if (result !== undefined)
          $Array.push(results, result);
      } catch (e) {
        exceptionHandler.handle('Error in event handler for ' +
            (this.eventName ? this.eventName : '(unknown)'),
          e);
      }
    }
    if (results.length)
      return {results: results};
  }

  // Can be overridden to support custom dispatching.
  EventImpl.prototype.dispatchToListener = function(callback, args) {
    return $Function.apply(callback, null, args);
  }

  // Dispatches this event object to all listeners, passing all supplied
  // arguments to this function each listener.
  EventImpl.prototype.dispatch = function(varargs) {
    return this.dispatch_($Array.slice(arguments), undefined);
  };

  // Detaches this event object from its name.
  EventImpl.prototype.detach_ = function() {
    this.attachmentStrategy.detach(false);
  };

  EventImpl.prototype.destroy_ = function() {
    this.listeners.length = 0;
    this.detach_();
    this.destroyed = exceptionHandler.getStackTrace();
  };

  EventImpl.prototype.addRules = function(rules, opt_cb) {
    if (!this.eventOptions.supportsRules)
      throw new Error("This event does not support rules.");

    // Takes a list of JSON datatype identifiers and returns a schema fragment
    // that verifies that a JSON object corresponds to an array of only these
    // data types.
    function buildArrayOfChoicesSchema(typesList) {
      return {
        'type': 'array',
        'items': {
          'choices': typesList.map(function(el) {return {'$ref': el};})
        }
      };
    };

    // Validate conditions and actions against specific schemas of this
    // event object type.
    // |rules| is an array of JSON objects that follow the Rule type of the
    // declarative extension APIs. |conditions| is an array of JSON type
    // identifiers that are allowed to occur in the conditions attribute of each
    // rule. Likewise, |actions| is an array of JSON type identifiers that are
    // allowed to occur in the actions attribute of each rule.
    function validateRules(rules, conditions, actions) {
      var conditionsSchema = buildArrayOfChoicesSchema(conditions);
      var actionsSchema = buildArrayOfChoicesSchema(actions);
      $Array.forEach(rules, function(rule) {
        validate([rule.conditions], [conditionsSchema]);
        validate([rule.actions], [actionsSchema]);
      });
    };

    if (!this.eventOptions.conditions || !this.eventOptions.actions) {
      throw new Error('Event ' + this.eventName + ' misses ' +
                      'conditions or actions in the API specification.');
    }

    validateRules(rules,
                  this.eventOptions.conditions,
                  this.eventOptions.actions);

    ensureRuleSchemasLoaded();
    // We remove the first parameter from the validation to give the user more
    // meaningful error messages.
    validate([this.webViewInstanceId, rules, opt_cb],
             $Array.splice(
                 $Array.slice(ruleFunctionSchemas.addRules.parameters), 1));
    sendRequest(
      "events.addRules",
      [this.eventName, this.webViewInstanceId, rules,  opt_cb],
      ruleFunctionSchemas.addRules.parameters);
  }

  EventImpl.prototype.removeRules = function(ruleIdentifiers, opt_cb) {
    if (!this.eventOptions.supportsRules)
      throw new Error("This event does not support rules.");
    ensureRuleSchemasLoaded();
    // We remove the first parameter from the validation to give the user more
    // meaningful error messages.
    validate([this.webViewInstanceId, ruleIdentifiers, opt_cb],
             $Array.splice(
                 $Array.slice(ruleFunctionSchemas.removeRules.parameters), 1));
    sendRequest("events.removeRules",
                [this.eventName,
                 this.webViewInstanceId,
                 ruleIdentifiers,
                 opt_cb],
                ruleFunctionSchemas.removeRules.parameters);
  }

  EventImpl.prototype.getRules = function(ruleIdentifiers, cb) {
    if (!this.eventOptions.supportsRules)
      throw new Error("This event does not support rules.");
    ensureRuleSchemasLoaded();
    // We remove the first parameter from the validation to give the user more
    // meaningful error messages.
    validate([this.webViewInstanceId, ruleIdentifiers, cb],
             $Array.splice(
                 $Array.slice(ruleFunctionSchemas.getRules.parameters), 1));

    sendRequest(
      "events.getRules",
      [this.eventName, this.webViewInstanceId, ruleIdentifiers, cb],
      ruleFunctionSchemas.getRules.parameters);
  }

  var Event = utils.expose('Event', EventImpl, { functions: [
    'addListener',
    'removeListener',
    'hasListener',
    'hasListeners',
    'dispatchToListener',
    'dispatch',
    'addRules',
    'removeRules',
    'getRules'
  ] });

  // NOTE: Event is (lazily) exposed as chrome.Event from dispatcher.cc.
  exports.$set('Event', Event);

  exports.$set('dispatchEvent', dispatchEvent);
  exports.$set('parseEventOptions', parseEventOptions);
  exports.$set('registerArgumentMassager', registerArgumentMassager);

})

//----------------------------------------------------------------------

(function(define, require, requireNative, requireAsync, exports, console, privates,$Array, $Function, $JSON, $Object, $RegExp, $String, $Error) {'use strict';// Copyright 2014 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.

// -----------------------------------------------------------------------------
// NOTE: If you change this file you need to touch
// extension_renderer_resources.grd to have your change take effect.
// -----------------------------------------------------------------------------

//==============================================================================
// This file contains a class that implements a subset of JSON Schema.
// See: http://www.json.com/json-schema-proposal/ for more details.
//
// The following features of JSON Schema are not implemented:
// - requires
// - unique
// - disallow
// - union types (but replaced with 'choices')
//
// The following properties are not applicable to the interface exposed by
// this class:
// - options
// - readonly
// - title
// - description
// - format
// - default
// - transient
// - hidden
//
// There are also these departures from the JSON Schema proposal:
// - function and undefined types are supported
// - null counts as 'unspecified' for optional values
// - added the 'choices' property, to allow specifying a list of possible types
//   for a value
// - by default an "object" typed schema does not allow additional properties.
//   if present, "additionalProperties" is to be a schema against which all
//   additional properties will be validated.
//==============================================================================

var loadTypeSchema = require('utils').loadTypeSchema;
var CHECK = requireNative('logging').CHECK;

function isInstanceOfClass(instance, className) {
  while ((instance = instance.__proto__)) {
    if (instance.constructor.name == className)
      return true;
  }
  return false;
}

function isOptionalValue(value) {
  return typeof(value) === 'undefined' || value === null;
}

function enumToString(enumValue) {
  if (enumValue.name === undefined)
    return enumValue;

  return enumValue.name;
}

/**
 * Validates an instance against a schema and accumulates errors. Usage:
 *
 * var validator = new JSONSchemaValidator();
 * validator.validate(inst, schema);
 * if (validator.errors.length == 0)
 *   console.log("Valid!");
 * else
 *   console.log(validator.errors);
 *
 * The errors property contains a list of objects. Each object has two
 * properties: "path" and "message". The "path" property contains the path to
 * the key that had the problem, and the "message" property contains a sentence
 * describing the error.
 */
function JSONSchemaValidator() {
  this.errors = [];
  this.types = [];
}

JSONSchemaValidator.messages = {
  invalidEnum: "Value must be one of: [*].",
  propertyRequired: "Property is required.",
  unexpectedProperty: "Unexpected property.",
  arrayMinItems: "Array must have at least * items.",
  arrayMaxItems: "Array must not have more than * items.",
  itemRequired: "Item is required.",
  stringMinLength: "String must be at least * characters long.",
  stringMaxLength: "String must not be more than * characters long.",
  stringPattern: "String must match the pattern: *.",
  numberFiniteNotNan: "Value must not be *.",
  numberMinValue: "Value must not be less than *.",
  numberMaxValue: "Value must not be greater than *.",
  numberIntValue: "Value must fit in a 32-bit signed integer.",
  numberMaxDecimal: "Value must not have more than * decimal places.",
  invalidType: "Expected '*' but got '*'.",
  invalidTypeIntegerNumber:
      "Expected 'integer' but got 'number', consider using Math.round().",
  invalidChoice: "Value does not match any valid type choices.",
  invalidPropertyType: "Missing property type.",
  schemaRequired: "Schema value required.",
  unknownSchemaReference: "Unknown schema reference: *.",
  notInstance: "Object must be an instance of *."
};

/**
 * Builds an error message. Key is the property in the |errors| object, and
 * |opt_replacements| is an array of values to replace "*" characters with.
 */
JSONSchemaValidator.formatError = function(key, opt_replacements) {
  var message = this.messages[key];
  if (opt_replacements) {
    for (var i = 0; i < opt_replacements.length; i++) {
      message = message.replace("*", opt_replacements[i]);
    }
  }
  return message;
};

/**
 * Classifies a value as one of the JSON schema primitive types. Note that we
 * don't explicitly disallow 'function', because we want to allow functions in
 * the input values.
 */
JSONSchemaValidator.getType = function(value) {
  var s = typeof value;

  if (s == "object") {
    if (value === null) {
      return "null";
    } else if (Object.prototype.toString.call(value) == "[object Array]") {
      return "array";
    } else if (Object.prototype.toString.call(value) ==
               "[object ArrayBuffer]") {
      return "binary";
    }
  } else if (s == "number") {
    if (value % 1 == 0) {
      return "integer";
    }
  }

  return s;
};

/**
 * Add types that may be referenced by validated schemas that reference them
 * with "$ref": <typeId>. Each type must be a valid schema and define an
 * "id" property.
 */
JSONSchemaValidator.prototype.addTypes = function(typeOrTypeList) {
  function addType(validator, type) {
    if (!type.id)
      throw new Error("Attempt to addType with missing 'id' property");
    validator.types[type.id] = type;
  }

  if (typeOrTypeList instanceof Array) {
    for (var i = 0; i < typeOrTypeList.length; i++) {
      addType(this, typeOrTypeList[i]);
    }
  } else {
    addType(this, typeOrTypeList);
  }
}

/**
 * Returns a list of strings of the types that this schema accepts.
 */
JSONSchemaValidator.prototype.getAllTypesForSchema = function(schema) {
  var schemaTypes = [];
  if (schema.type)
    $Array.push(schemaTypes, schema.type);
  if (schema.choices) {
    for (var i = 0; i < schema.choices.length; i++) {
      var choiceTypes = this.getAllTypesForSchema(schema.choices[i]);
      schemaTypes = $Array.concat(schemaTypes, choiceTypes);
    }
  }
  var ref = schema['$ref'];
  if (ref) {
    var type = this.getOrAddType(ref);
    CHECK(type, 'Could not find type ' + ref);
    schemaTypes = $Array.concat(schemaTypes, this.getAllTypesForSchema(type));
  }
  return schemaTypes;
};

JSONSchemaValidator.prototype.getOrAddType = function(typeName) {
  if (!this.types[typeName])
    this.types[typeName] = loadTypeSchema(typeName);
  return this.types[typeName];
};

/**
 * Returns true if |schema| would accept an argument of type |type|.
 */
JSONSchemaValidator.prototype.isValidSchemaType = function(type, schema) {
  if (type == 'any')
    return true;

  // TODO(kalman): I don't understand this code. How can type be "null"?
  if (schema.optional && (type == "null" || type == "undefined"))
    return true;

  var schemaTypes = this.getAllTypesForSchema(schema);
  for (var i = 0; i < schemaTypes.length; i++) {
    if (schemaTypes[i] == "any" || type == schemaTypes[i] ||
        (type == "integer" && schemaTypes[i] == "number"))
      return true;
  }

  return false;
};

/**
 * Returns true if there is a non-null argument that both |schema1| and
 * |schema2| would accept.
 */
JSONSchemaValidator.prototype.checkSchemaOverlap = function(schema1, schema2) {
  var schema1Types = this.getAllTypesForSchema(schema1);
  for (var i = 0; i < schema1Types.length; i++) {
    if (this.isValidSchemaType(schema1Types[i], schema2))
      return true;
  }
  return false;
};

/**
 * Validates an instance against a schema. The instance can be any JavaScript
 * value and will be validated recursively. When this method returns, the
 * |errors| property will contain a list of errors, if any.
 */
JSONSchemaValidator.prototype.validate = function(instance, schema, opt_path) {
  var path = opt_path || "";

  if (!schema) {
    this.addError(path, "schemaRequired");
    return;
  }

  // If this schema defines itself as reference type, save it in this.types.
  if (schema.id)
    this.types[schema.id] = schema;

  // If the schema has an extends property, the instance must validate against
  // that schema too.
  if (schema.extends)
    this.validate(instance, schema.extends, path);

  // If the schema has a $ref property, the instance must validate against
  // that schema too. It must be present in this.types to be referenced.
  var ref = schema["$ref"];
  if (ref) {
    if (!this.getOrAddType(ref))
      this.addError(path, "unknownSchemaReference", [ ref ]);
    else
      this.validate(instance, this.getOrAddType(ref), path)
  }

  // If the schema has a choices property, the instance must validate against at
  // least one of the items in that array.
  if (schema.choices) {
    this.validateChoices(instance, schema, path);
    return;
  }

  // If the schema has an enum property, the instance must be one of those
  // values.
  if (schema.enum) {
    if (!this.validateEnum(instance, schema, path))
      return;
  }

  if (schema.type && schema.type != "any") {
    if (!this.validateType(instance, schema, path))
      return;

    // Type-specific validation.
    switch (schema.type) {
      case "object":
        this.validateObject(instance, schema, path);
        break;
      case "array":
        this.validateArray(instance, schema, path);
        break;
      case "string":
        this.validateString(instance, schema, path);
        break;
      case "number":
      case "integer":
        this.validateNumber(instance, schema, path);
        break;
    }
  }
};

/**
 * Validates an instance against a choices schema. The instance must match at
 * least one of the provided choices.
 */
JSONSchemaValidator.prototype.validateChoices =
    function(instance, schema, path) {
  var originalErrors = this.errors;

  for (var i = 0; i < schema.choices.length; i++) {
    this.errors = [];
    this.validate(instance, schema.choices[i], path);
    if (this.errors.length == 0) {
      this.errors = originalErrors;
      return;
    }
  }

  this.errors = originalErrors;
  this.addError(path, "invalidChoice");
};

/**
 * Validates an instance against a schema with an enum type. Populates the
 * |errors| property, and returns a boolean indicating whether the instance
 * validates.
 */
JSONSchemaValidator.prototype.validateEnum = function(instance, schema, path) {
  for (var i = 0; i < schema.enum.length; i++) {
    if (instance === enumToString(schema.enum[i]))
      return true;
  }

  this.addError(path, "invalidEnum",
                [schema.enum.map(enumToString).join(", ")]);
  return false;
};

/**
 * Validates an instance against an object schema and populates the errors
 * property.
 */
JSONSchemaValidator.prototype.validateObject =
    function(instance, schema, path) {
  if (schema.properties) {
    for (var prop in schema.properties) {
      // It is common in JavaScript to add properties to Object.prototype. This
      // check prevents such additions from being interpreted as required
      // schema properties.
      // TODO(aa): If it ever turns out that we actually want this to work,
      // there are other checks we could put here, like requiring that schema
      // properties be objects that have a 'type' property.
      if (!$Object.hasOwnProperty(schema.properties, prop))
        continue;

      var propPath = path ? path + "." + prop : prop;
      if (schema.properties[prop] == undefined) {
        this.addError(propPath, "invalidPropertyType");
      } else if (prop in instance && !isOptionalValue(instance[prop])) {
        this.validate(instance[prop], schema.properties[prop], propPath);
      } else if (!schema.properties[prop].optional) {
        this.addError(propPath, "propertyRequired");
      }
    }
  }

  // If "instanceof" property is set, check that this object inherits from
  // the specified constructor (function).
  if (schema.isInstanceOf) {
    if (!isInstanceOfClass(instance, schema.isInstanceOf))
      this.addError(propPath, "notInstance", [schema.isInstanceOf]);
  }

  // Exit early from additional property check if "type":"any" is defined.
  if (schema.additionalProperties &&
      schema.additionalProperties.type &&
      schema.additionalProperties.type == "any") {
    return;
  }

  // By default, additional properties are not allowed on instance objects. This
  // can be overridden by setting the additionalProperties property to a schema
  // which any additional properties must validate against.
  for (var prop in instance) {
    if (schema.properties && prop in schema.properties)
      continue;

    // Any properties inherited through the prototype are ignored.
    if (!$Object.hasOwnProperty(instance, prop))
      continue;

    var propPath = path ? path + "." + prop : prop;
    if (schema.additionalProperties)
      this.validate(instance[prop], schema.additionalProperties, propPath);
    else
      this.addError(propPath, "unexpectedProperty");
  }
};

/**
 * Validates an instance against an array schema and populates the errors
 * property.
 */
JSONSchemaValidator.prototype.validateArray = function(instance, schema, path) {
  var typeOfItems = JSONSchemaValidator.getType(schema.items);

  if (typeOfItems == 'object') {
    if (schema.minItems && instance.length < schema.minItems) {
      this.addError(path, "arrayMinItems", [schema.minItems]);
    }

    if (typeof schema.maxItems != "undefined" &&
        instance.length > schema.maxItems) {
      this.addError(path, "arrayMaxItems", [schema.maxItems]);
    }

    // If the items property is a single schema, each item in the array must
    // have that schema.
    for (var i = 0; i < instance.length; i++) {
      this.validate(instance[i], schema.items, path + "." + i);
    }
  } else if (typeOfItems == 'array') {
    // If the items property is an array of schemas, each item in the array must
    // validate against the corresponding schema.
    for (var i = 0; i < schema.items.length; i++) {
      var itemPath = path ? path + "." + i : String(i);
      if (i in instance && !isOptionalValue(instance[i])) {
        this.validate(instance[i], schema.items[i], itemPath);
      } else if (!schema.items[i].optional) {
        this.addError(itemPath, "itemRequired");
      }
    }

    if (schema.additionalProperties) {
      for (var i = schema.items.length; i < instance.length; i++) {
        var itemPath = path ? path + "." + i : String(i);
        this.validate(instance[i], schema.additionalProperties, itemPath);
      }
    } else {
      if (instance.length > schema.items.length) {
        this.addError(path, "arrayMaxItems", [schema.items.length]);
      }
    }
  }
};

/**
 * Validates a string and populates the errors property.
 */
JSONSchemaValidator.prototype.validateString =
    function(instance, schema, path) {
  if (schema.minLength && instance.length < schema.minLength)
    this.addError(path, "stringMinLength", [schema.minLength]);

  if (schema.maxLength && instance.length > schema.maxLength)
    this.addError(path, "stringMaxLength", [schema.maxLength]);

  if (schema.pattern && !schema.pattern.test(instance))
    this.addError(path, "stringPattern", [schema.pattern]);
};

/**
 * Validates a number and populates the errors property. The instance is
 * assumed to be a number.
 */
JSONSchemaValidator.prototype.validateNumber =
    function(instance, schema, path) {
  // Forbid NaN, +Infinity, and -Infinity.  Our APIs don't use them, and
  // JSON serialization encodes them as 'null'.  Re-evaluate supporting
  // them if we add an API that could reasonably take them as a parameter.
  if (isNaN(instance) ||
      instance == Number.POSITIVE_INFINITY ||
      instance == Number.NEGATIVE_INFINITY )
    this.addError(path, "numberFiniteNotNan", [instance]);

  if (schema.minimum !== undefined && instance < schema.minimum)
    this.addError(path, "numberMinValue", [schema.minimum]);

  if (schema.maximum !== undefined && instance > schema.maximum)
    this.addError(path, "numberMaxValue", [schema.maximum]);

  // Check for integer values outside of -2^31..2^31-1.
  if (schema.type === "integer" && (instance | 0) !== instance)
    this.addError(path, "numberIntValue", []);

  if (schema.maxDecimal && instance * Math.pow(10, schema.maxDecimal) % 1)
    this.addError(path, "numberMaxDecimal", [schema.maxDecimal]);
};

/**
 * Validates the primitive type of an instance and populates the errors
 * property. Returns true if the instance validates, false otherwise.
 */
JSONSchemaValidator.prototype.validateType = function(instance, schema, path) {
  var actualType = JSONSchemaValidator.getType(instance);
  if (schema.type == actualType ||
      (schema.type == "number" && actualType == "integer")) {
    return true;
  } else if (schema.type == "integer" && actualType == "number") {
    this.addError(path, "invalidTypeIntegerNumber");
    return false;
  } else {
    this.addError(path, "invalidType", [schema.type, actualType]);
    return false;
  }
};

/**
 * Adds an error message. |key| is an index into the |messages| object.
 * |replacements| is an array of values to replace '*' characters in the
 * message.
 */
JSONSchemaValidator.prototype.addError = function(path, key, replacements) {
  $Array.push(this.errors, {
    path: path,
    message: JSONSchemaValidator.formatError(key, replacements)
  });
};

/**
 * Resets errors to an empty list so you can call 'validate' again.
 */
JSONSchemaValidator.prototype.resetErrors = function() {
  this.errors = [];
};

exports.$set('JSONSchemaValidator', JSONSchemaValidator);

})

//----------------------------------------------------------------------

(function(define, require, requireNative, requireAsync, exports, console, privates,$Array, $Function, $JSON, $Object, $RegExp, $String, $Error) {'use strict';// Copyright 2014 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.

var GetAvailability = requireNative('v8_context').GetAvailability;
var GetGlobal = requireNative('sendRequest').GetGlobal;

// Utility for setting chrome.*.lastError.
//
// A utility here is useful for two reasons:
//  1. For backwards compatibility we need to set chrome.extension.lastError,
//     but not all contexts actually have access to the extension namespace.
//  2. When calling across contexts, the global object that gets lastError set
//     needs to be that of the caller. We force callers to explicitly specify
//     the chrome object to try to prevent bugs here.

/**
 * Sets the last error for |name| on |targetChrome| to |message| with an
 * optional |stack|.
 */
function set(name, message, stack, targetChrome) {
  if (!targetChrome) {
    var errorMessage = name + ': ' + message;
    if (stack != null && stack != '')
      errorMessage += '\n' + stack;
    throw new Error('No chrome object to set error: ' + errorMessage);
  }
  clear(targetChrome);  // in case somebody has set a sneaky getter/setter

  var errorObject = { message: message };
  if (GetAvailability('extension.lastError').is_available)
    targetChrome.extension.lastError = errorObject;

  assertRuntimeIsAvailable();

  // We check to see if developers access runtime.lastError in order to decide
  // whether or not to log it in the (error) console.
  privates(targetChrome.runtime).accessedLastError = false;
  $Object.defineProperty(targetChrome.runtime, 'lastError', {
      configurable: true,
      get: function() {
        privates(targetChrome.runtime).accessedLastError = true;
        return errorObject;
      },
      set: function(error) {
        errorObject = errorObject;
      }});
};

/**
 * Check if anyone has checked chrome.runtime.lastError since it was set.
 * @param {Object} targetChrome the Chrome object to check.
 * @return boolean True if the lastError property was set.
 */
function hasAccessed(targetChrome) {
  assertRuntimeIsAvailable();
  return privates(targetChrome.runtime).accessedLastError === true;
}

/**
 * Check whether there is an error set on |targetChrome| without setting
 * |accessedLastError|.
 * @param {Object} targetChrome the Chrome object to check.
 * @return boolean Whether lastError has been set.
 */
function hasError(targetChrome) {
  if (!targetChrome)
    throw new Error('No target chrome to check');

  assertRuntimeIsAvailable();
  if ('lastError' in targetChrome.runtime)
    return true;

  return false;
};

/**
 * Clears the last error on |targetChrome|.
 */
function clear(targetChrome) {
  if (!targetChrome)
    throw new Error('No target chrome to clear error');

  if (GetAvailability('extension.lastError').is_available)
   delete targetChrome.extension.lastError;

  assertRuntimeIsAvailable();
  delete targetChrome.runtime.lastError;
  delete privates(targetChrome.runtime).accessedLastError;
};

function assertRuntimeIsAvailable() {
  // chrome.runtime should always be available, but maybe it's disappeared for
  // some reason? Add debugging for http://crbug.com/258526.
  var runtimeAvailability = GetAvailability('runtime.lastError');
  if (!runtimeAvailability.is_available) {
    throw new Error('runtime.lastError is not available: ' +
                    runtimeAvailability.message);
  }
  if (!chrome.runtime)
    throw new Error('runtime namespace is null or undefined');
}

/**
 * Runs |callback(args)| with last error args as in set().
 *
 * The target chrome object is the global object's of the callback, so this
 * method won't work if the real callback has been wrapped (etc).
 */
function run(name, message, stack, callback, args) {
  var targetChrome = GetGlobal(callback).chrome;
  set(name, message, stack, targetChrome);
  try {
    $Function.apply(callback, undefined, args);
  } finally {
    reportIfUnchecked(name, targetChrome, stack);
    clear(targetChrome);
  }
}

/**
 * Checks whether chrome.runtime.lastError has been accessed if set.
 * If it was set but not accessed, the error is reported to the console.
 *
 * @param {string=} name - name of API.
 * @param {Object} targetChrome - the Chrome object to check.
 * @param {string=} stack - Stack trace of the call up to the error.
 */
function reportIfUnchecked(name, targetChrome, stack) {
  if (hasAccessed(targetChrome) || !hasError(targetChrome))
    return;
  var message = targetChrome.runtime.lastError.message;
  console.error("Unchecked runtime.lastError while running " +
      (name || "unknown") + ": " + message + (stack ? "\n" + stack : ""));
}

exports.$set('clear', clear);
exports.$set('hasAccessed', hasAccessed);
exports.$set('hasError', hasError);
exports.$set('set', set);
exports.$set('run', run);
exports.$set('reportIfUnchecked', reportIfUnchecked);

})


//------------------------------------------------------------------------

(function(define, require, requireNative, requireAsync, exports, console, privates,$Array, $Function, $JSON, $Object, $RegExp, $String, $Error) {'use strict';// Copyright 2014 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.

// chrome.runtime.messaging API implementation.

  // TODO(kalman): factor requiring chrome out of here.
  var chrome = requireNative('chrome').GetChrome();
  var Event = require('event_bindings').Event;
  var lastError = require('lastError');
  var logActivity = requireNative('activityLogger');
  var logging = requireNative('logging');
  var messagingNatives = requireNative('messaging_natives');
  var processNatives = requireNative('process');
  var utils = require('utils');
  var messagingUtils = require('messaging_utils');

  // The reserved channel name for the sendRequest/send(Native)Message APIs.
  // Note: sendRequest is deprecated.
  var kRequestChannel = "chrome.extension.sendRequest";
  var kMessageChannel = "chrome.runtime.sendMessage";
  var kNativeMessageChannel = "chrome.runtime.sendNativeMessage";

  // Map of port IDs to port object.
  var ports = {};

  // Change even to odd and vice versa, to get the other side of a given
  // channel.
  function getOppositePortId(portId) { return portId ^ 1; }

  // Port object.  Represents a connection to another script context through
  // which messages can be passed.
  function PortImpl(portId, opt_name) {
    this.portId_ = portId;
    this.name = opt_name;

    var portSchema = {name: 'port', $ref: 'runtime.Port'};
    var options = {unmanaged: true};
    this.onDisconnect = new Event(null, [portSchema], options);
    this.onMessage = new Event(
        null,
        [{name: 'message', type: 'any', optional: true}, portSchema],
        options);
    this.onDestroy_ = null;
  }

  // Sends a message asynchronously to the context on the other end of this
  // port.
  PortImpl.prototype.postMessage = function(msg) {
    // JSON.stringify doesn't support a root object which is undefined.
    if (msg === undefined)
      msg = null;
    msg = $JSON.stringify(msg);
    if (msg === undefined) {
      // JSON.stringify can fail with unserializable objects. Log an error and
      // drop the message.
      //
      // TODO(kalman/mpcomplete): it would be better to do the same validation
      // here that we do for runtime.sendMessage (and variants), i.e. throw an
      // schema validation Error, but just maintain the old behaviour until
      // there's a good reason not to (http://crbug.com/263077).
      console.error('Illegal argument to Port.postMessage');
      return;
    }
    messagingNatives.PostMessage(this.portId_, msg);
  };

  // Disconnects the port from the other end.
  PortImpl.prototype.disconnect = function() {
    messagingNatives.CloseChannel(this.portId_, true);
    this.destroy_();
  };

  PortImpl.prototype.destroy_ = function() {
    if (this.onDestroy_)
      this.onDestroy_();
    privates(this.onDisconnect).impl.destroy_();
    privates(this.onMessage).impl.destroy_();
    messagingNatives.PortRelease(this.portId_);
    delete ports[this.portId_];
  };

  // Returns true if the specified port id is in this context. This is used by
  // the C++ to avoid creating the javascript message for all the contexts that
  // don't care about a particular message.
  function hasPort(portId) {
    return portId in ports;
  };

  // Hidden port creation function.  We don't want to expose an API that lets
  // people add arbitrary port IDs to the port list.
  function createPort(portId, opt_name) {
    if (ports[portId])
      throw new Error("Port '" + portId + "' already exists.");
    var port = new Port(portId, opt_name);
    ports[portId] = port;
    messagingNatives.PortAddRef(portId);
    return port;
  };

  // Helper function for dispatchOnRequest.
  function handleSendRequestError(isSendMessage,
                                  responseCallbackPreserved,
                                  sourceExtensionId,
                                  targetExtensionId,
                                  sourceUrl) {
    var errorMsg = [];
    var eventName = isSendMessage ? "runtime.onMessage" : "extension.onRequest";
    if (isSendMessage && !responseCallbackPreserved) {
      $Array.push(errorMsg,
          "The chrome." + eventName + " listener must return true if you " +
          "want to send a response after the listener returns");
    } else {
      $Array.push(errorMsg,
          "Cannot send a response more than once per chrome." + eventName +
          " listener per document");
    }
    $Array.push(errorMsg, "(message was sent by extension" + sourceExtensionId);
    if (sourceExtensionId != "" && sourceExtensionId != targetExtensionId)
      $Array.push(errorMsg, "for extension " + targetExtensionId);
    if (sourceUrl != "")
      $Array.push(errorMsg, "for URL " + sourceUrl);
    lastError.set(eventName, errorMsg.join(" ") + ").", null, chrome);
  }

  // Helper function for dispatchOnConnect
  function dispatchOnRequest(portId, channelName, sender,
                             sourceExtensionId, targetExtensionId, sourceUrl,
                             isExternal) {
    var isSendMessage = channelName == kMessageChannel;
    var requestEvent = null;
    if (isSendMessage) {
      if (chrome.runtime) {
        requestEvent = isExternal ? chrome.runtime.onMessageExternal
                                  : chrome.runtime.onMessage;
      }
    } else {
      if (chrome.extension) {
        requestEvent = isExternal ? chrome.extension.onRequestExternal
                                  : chrome.extension.onRequest;
      }
    }
    if (!requestEvent)
      return false;
    if (!requestEvent.hasListeners())
      return false;
    var port = createPort(portId, channelName);

    function messageListener(request) {
      var responseCallbackPreserved = false;
      var responseCallback = function(response) {
        if (port) {
          port.postMessage(response);
          privates(port).impl.destroy_();
          port = null;
        } else {
          // We nulled out port when sending the response, and now the page
          // is trying to send another response for the same request.
          handleSendRequestError(isSendMessage, responseCallbackPreserved,
                                 sourceExtensionId, targetExtensionId);
        }
      };
      // In case the extension never invokes the responseCallback, and also
      // doesn't keep a reference to it, we need to clean up the port. Do
      // so by attaching to the garbage collection of the responseCallback
      // using some native hackery.
      //
      // If the context is destroyed before this has a chance to execute,
      // BindToGC knows to release |portId| (important for updating C++ state
      // both in this renderer and on the other end). We don't need to clear
      // any JavaScript state, as calling destroy_() would usually do - but
      // the context has been destroyed, so there isn't any JS state to clear.
      messagingNatives.BindToGC(responseCallback, function() {
        if (port) {
          privates(port).impl.destroy_();
          port = null;
        }
      }, portId);
      var rv = requestEvent.dispatch(request, sender, responseCallback);
      if (isSendMessage) {
        responseCallbackPreserved =
            rv && rv.results && $Array.indexOf(rv.results, true) > -1;
        if (!responseCallbackPreserved && port) {
          // If they didn't access the response callback, they're not
          // going to send a response, so clean up the port immediately.
          privates(port).impl.destroy_();
          port = null;
        }
      }
    }

    privates(port).impl.onDestroy_ = function() {
      port.onMessage.removeListener(messageListener);
    };
    port.onMessage.addListener(messageListener);

    var eventName = isSendMessage ? "runtime.onMessage" : "extension.onRequest";
    if (isExternal)
      eventName += "External";
    logActivity.LogEvent(targetExtensionId,
                         eventName,
                         [sourceExtensionId, sourceUrl]);
    return true;
  }

  // Called by native code when a channel has been opened to this context.
  function dispatchOnConnect(portId,
                             channelName,
                             sourceTab,
                             sourceFrameId,
                             guestProcessId,
                             guestRenderFrameRoutingId,
                             sourceExtensionId,
                             targetExtensionId,
                             sourceUrl,
                             tlsChannelId) {
    // Only create a new Port if someone is actually listening for a connection.
    // In addition to being an optimization, this also fixes a bug where if 2
    // channels were opened to and from the same process, closing one would
    // close both.
    var extensionId = processNatives.GetExtensionId();

    // messaging_bindings.cc should ensure that this method only gets called for
    // the right extension.
    logging.CHECK(targetExtensionId == extensionId);

    if (ports[getOppositePortId(portId)])
      return false;  // this channel was opened by us, so ignore it

    // Determine whether this is coming from another extension, so we can use
    // the right event.
    var isExternal = sourceExtensionId != extensionId;

    var sender = {};
    if (sourceExtensionId != '')
      sender.id = sourceExtensionId;
    if (sourceUrl)
      sender.url = sourceUrl;
    if (sourceTab)
      sender.tab = sourceTab;
    if (sourceFrameId >= 0)
      sender.frameId = sourceFrameId;
    if (typeof guestProcessId !== 'undefined' &&
        typeof guestRenderFrameRoutingId !== 'undefined') {
      // Note that |guestProcessId| and |guestRenderFrameRoutingId| are not
      // standard fields on MessageSender and should not be exposed to drive-by
      // extensions; it is only exposed to component extensions.
      logging.CHECK(processNatives.IsComponentExtension(),
          "GuestProcessId can only be exposed to component extensions.");
      sender.guestProcessId = guestProcessId;
      sender.guestRenderFrameRoutingId = guestRenderFrameRoutingId;
    }
    if (typeof tlsChannelId != 'undefined')
      sender.tlsChannelId = tlsChannelId;

    // Special case for sendRequest/onRequest and sendMessage/onMessage.
    if (channelName == kRequestChannel || channelName == kMessageChannel) {
      return dispatchOnRequest(portId, channelName, sender,
                               sourceExtensionId, targetExtensionId, sourceUrl,
                               isExternal);
    }

    var connectEvent = null;
    if (chrome.runtime) {
      connectEvent = isExternal ? chrome.runtime.onConnectExternal
                                : chrome.runtime.onConnect;
    }
    if (!connectEvent)
      return false;
    if (!connectEvent.hasListeners())
      return false;

    var port = createPort(portId, channelName);
    port.sender = sender;
    if (processNatives.manifestVersion < 2)
      port.tab = port.sender.tab;

    var eventName = (isExternal ?
        "runtime.onConnectExternal" : "runtime.onConnect");
    connectEvent.dispatch(port);
    logActivity.LogEvent(targetExtensionId,
                         eventName,
                         [sourceExtensionId]);
    return true;
  };

  // Called by native code when a channel has been closed.
  function dispatchOnDisconnect(portId, errorMessage) {
    var port = ports[portId];
    if (port) {
      // Update the renderer's port bookkeeping, without notifying the browser.
      messagingNatives.CloseChannel(portId, false);
      if (errorMessage)
        lastError.set('Port', errorMessage, null, chrome);
      try {
        port.onDisconnect.dispatch(port);
      } finally {
        privates(port).impl.destroy_();
        lastError.clear(chrome);
      }
    }
  };

  // Called by native code when a message has been sent to the given port.
  function dispatchOnMessage(msg, portId) {
    var port = ports[portId];
    if (port) {
      if (msg)
        msg = $JSON.parse(msg);
      port.onMessage.dispatch(msg, port);
    }
  };

  // Shared implementation used by tabs.sendMessage and runtime.sendMessage.
  function sendMessageImpl(port, request, responseCallback) {
    if (port.name != kNativeMessageChannel)
      port.postMessage(request);

    if (port.name == kMessageChannel && !responseCallback) {
      // TODO(mpcomplete): Do this for the old sendRequest API too, after
      // verifying it doesn't break anything.
      // Go ahead and disconnect immediately if the sender is not expecting
      // a response.
      port.disconnect();
      return;
    }

    // Ensure the callback exists for the older sendRequest API.
    if (!responseCallback)
      responseCallback = function() {};

    // Note: make sure to manually remove the onMessage/onDisconnect listeners
    // that we added before destroying the Port, a workaround to a bug in Port
    // where any onMessage/onDisconnect listeners added but not removed will
    // be leaked when the Port is destroyed.
    // http://crbug.com/320723 tracks a sustainable fix.

    function disconnectListener() {
      // For onDisconnects, we only notify the callback if there was an error.
      if (chrome.runtime && chrome.runtime.lastError)
        responseCallback();
    }

    function messageListener(response) {
      try {
        responseCallback(response);
      } finally {
        port.disconnect();
      }
    }

    privates(port).impl.onDestroy_ = function() {
      port.onDisconnect.removeListener(disconnectListener);
      port.onMessage.removeListener(messageListener);
    };
    port.onDisconnect.addListener(disconnectListener);
    port.onMessage.addListener(messageListener);
  };

  function sendMessageUpdateArguments(functionName, hasOptionsArgument) {
    // skip functionName and hasOptionsArgument
    var args = $Array.slice(arguments, 2);
    var alignedArgs = messagingUtils.alignSendMessageArguments(args,
        hasOptionsArgument);
    if (!alignedArgs)
      throw new Error('Invalid arguments to ' + functionName + '.');
    return alignedArgs;
  }

var Port = utils.expose('Port', PortImpl, { functions: [
    'disconnect',
    'postMessage'
  ],
  properties: [
    'name',
    'onDisconnect',
    'onMessage'
  ] });

exports.$set('kRequestChannel', kRequestChannel);
exports.$set('kMessageChannel', kMessageChannel);
exports.$set('kNativeMessageChannel', kNativeMessageChannel);
exports.$set('Port', Port);
exports.$set('createPort', createPort);
exports.$set('sendMessageImpl', sendMessageImpl);
exports.$set('sendMessageUpdateArguments', sendMessageUpdateArguments);

// For C++ code to call.
exports.$set('hasPort', hasPort);
exports.$set('dispatchOnConnect', dispatchOnConnect);
exports.$set('dispatchOnDisconnect', dispatchOnDisconnect);
exports.$set('dispatchOnMessage', dispatchOnMessage);

})

//-----------------------------------------------------------------

(function(define, require, requireNative, requireAsync, exports, console, privates,$Array, $Function, $JSON, $Object, $RegExp, $String, $Error) {'use strict';// Copyright 2014 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.

// Routines used to normalize arguments to messaging functions.

function alignSendMessageArguments(args, hasOptionsArgument) {
  // Align missing (optional) function arguments with the arguments that
  // schema validation is expecting, e.g.
  //   extension.sendRequest(req)     -> extension.sendRequest(null, req)
  //   extension.sendRequest(req, cb) -> extension.sendRequest(null, req, cb)
  if (!args || !args.length)
    return null;
  var lastArg = args.length - 1;

  // responseCallback (last argument) is optional.
  var responseCallback = null;
  if (typeof args[lastArg] == 'function')
    responseCallback = args[lastArg--];

  var options = null;
  if (hasOptionsArgument && lastArg >= 1) {
    // options (third argument) is optional. It can also be ambiguous which
    // argument it should match. If there are more than two arguments remaining,
    // options is definitely present:
    if (lastArg > 1) {
      options = args[lastArg--];
    } else {
      // Exactly two arguments remaining. If the first argument is a string,
      // it should bind to targetId, and the second argument should bind to
      // request, which is required. In other words, when two arguments remain,
      // only bind options when the first argument cannot bind to targetId.
      if (!(args[0] === null || typeof args[0] == 'string'))
        options = args[lastArg--];
    }
  }

  // request (second argument) is required.
  var request = args[lastArg--];

  // targetId (first argument, extensionId in the manifest) is optional.
  var targetId = null;
  if (lastArg >= 0)
    targetId = args[lastArg--];

  if (lastArg != -1)
    return null;
  if (hasOptionsArgument)
    return [targetId, request, options, responseCallback];
  return [targetId, request, responseCallback];
}

exports.$set('alignSendMessageArguments', alignSendMessageArguments);

})

//-------------------------------------------------------------------

(function(define, require, requireNative, requireAsync, exports, console, privates,$Array, $Function, $JSON, $Object, $RegExp, $String, $Error) {'use strict';// Copyright 2014 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.

// Routines used to validate and normalize arguments.
// TODO(benwells): unit test this file.

var JSONSchemaValidator = require('json_schema').JSONSchemaValidator;

var schemaValidator = new JSONSchemaValidator();

// Validate arguments.
function validate(args, parameterSchemas) {
  if (args.length > parameterSchemas.length)
    throw new Error("Too many arguments.");
  for (var i = 0; i < parameterSchemas.length; i++) {
    if (i in args && args[i] !== null && args[i] !== undefined) {
      schemaValidator.resetErrors();
      schemaValidator.validate(args[i], parameterSchemas[i]);
      if (schemaValidator.errors.length == 0)
        continue;
      var message = "Invalid value for argument " + (i + 1) + ". ";
      for (var i = 0, err;
          err = schemaValidator.errors[i]; i++) {
        if (err.path) {
          message += "Property '" + err.path + "': ";
        }
        message += err.message;
        message = message.substring(0, message.length - 1);
        message += ", ";
      }
      message = message.substring(0, message.length - 2);
      message += ".";
      throw new Error(message);
    } else if (!parameterSchemas[i].optional) {
      throw new Error("Parameter " + (i + 1) + " (" +
          parameterSchemas[i].name + ") is required.");
    }
  }
}

// Generate all possible signatures for a given API function.
function getSignatures(parameterSchemas) {
  if (parameterSchemas.length === 0)
    return [[]];
  var signatures = [];
  var remaining = getSignatures($Array.slice(parameterSchemas, 1));
  for (var i = 0; i < remaining.length; i++)
    $Array.push(signatures, $Array.concat([parameterSchemas[0]], remaining[i]))
  if (parameterSchemas[0].optional)
    return $Array.concat(signatures, remaining);
  return signatures;
};

// Return true if arguments match a given signature's schema.
function argumentsMatchSignature(args, candidateSignature) {
  if (args.length != candidateSignature.length)
    return false;
  for (var i = 0; i < candidateSignature.length; i++) {
    var argType =  JSONSchemaValidator.getType(args[i]);
    if (!schemaValidator.isValidSchemaType(argType,
        candidateSignature[i]))
      return false;
  }
  return true;
};

// Finds the function signature for the given arguments.
function resolveSignature(args, definedSignature) {
  var candidateSignatures = getSignatures(definedSignature);
  for (var i = 0; i < candidateSignatures.length; i++) {
    if (argumentsMatchSignature(args, candidateSignatures[i]))
      return candidateSignatures[i];
  }
  return null;
};

// Returns a string representing the defined signature of the API function.
// Example return value for chrome.windows.getCurrent:
// "windows.getCurrent(optional object populate, function callback)"
function getParameterSignatureString(name, definedSignature) {
  var getSchemaTypeString = function(schema) {
    var schemaTypes = schemaValidator.getAllTypesForSchema(schema);
    var typeName = schemaTypes.join(" or ") + " " + schema.name;
    if (schema.optional)
      return "optional " + typeName;
    return typeName;
  };
  var typeNames = definedSignature.map(getSchemaTypeString);
  return name + "(" + typeNames.join(", ") + ")";
};

// Returns a string representing a call to an API function.
// Example return value for call: chrome.windows.get(1, callback) is:
// "windows.get(int, function)"
function getArgumentSignatureString(name, args) {
  var typeNames = args.map(JSONSchemaValidator.getType);
  return name + "(" + typeNames.join(", ") + ")";
};

// Finds the correct signature for the given arguments, then validates the
// arguments against that signature. Returns a 'normalized' arguments list
// where nulls are inserted where optional parameters were omitted.
// |args| is expected to be an array.
function normalizeArgumentsAndValidate(args, funDef) {
  if (funDef.allowAmbiguousOptionalArguments) {
    validate(args, funDef.definition.parameters);
    return args;
  }
  var definedSignature = funDef.definition.parameters;
  var resolvedSignature = resolveSignature(args, definedSignature);
  if (!resolvedSignature)
    throw new Error("Invocation of form " +
        getArgumentSignatureString(funDef.name, args) +
        " doesn't match definition " +
        getParameterSignatureString(funDef.name, definedSignature));
  validate(args, resolvedSignature);
  var normalizedArgs = [];
  var ai = 0;
  for (var si = 0; si < definedSignature.length; si++) {
    // Handle integer -0 as 0.
    if (JSONSchemaValidator.getType(args[ai]) === "integer" && args[ai] === 0)
      args[ai] = 0;
    if (definedSignature[si] === resolvedSignature[ai])
      $Array.push(normalizedArgs, args[ai++]);
    else
      $Array.push(normalizedArgs, null);
  }
  return normalizedArgs;
};

// Validates that a given schema for an API function is not ambiguous.
function isFunctionSignatureAmbiguous(functionDef) {
  if (functionDef.allowAmbiguousOptionalArguments)
    return false;
  var signaturesAmbiguous = function(signature1, signature2) {
    if (signature1.length != signature2.length)
      return false;
    for (var i = 0; i < signature1.length; i++) {
      if (!schemaValidator.checkSchemaOverlap(
          signature1[i], signature2[i]))
        return false;
    }
    return true;
  };
  var candidateSignatures = getSignatures(functionDef.parameters);
  for (var i = 0; i < candidateSignatures.length; i++) {
    for (var j = i + 1; j < candidateSignatures.length; j++) {
      if (signaturesAmbiguous(candidateSignatures[i], candidateSignatures[j]))
        return true;
    }
  }
  return false;
};

exports.$set('isFunctionSignatureAmbiguous', isFunctionSignatureAmbiguous);
exports.$set('normalizeArgumentsAndValidate', normalizeArgumentsAndValidate);
exports.$set('schemaValidator', schemaValidator);
exports.$set('validate', validate);

})

//---------------------------------------------------------------------

(function(define, require, requireNative, requireAsync, exports, console, privates,$Array, $Function, $JSON, $Object, $RegExp, $String, $Error) {'use strict';// Copyright 2014 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.

var exceptionHandler = require('uncaught_exception_handler');
var lastError = require('lastError');
var logging = requireNative('logging');
var natives = requireNative('sendRequest');
var validate = require('schemaUtils').validate;

// All outstanding requests from sendRequest().
var requests = {};

// Used to prevent double Activity Logging for API calls that use both custom
// bindings and ExtensionFunctions (via sendRequest).
var calledSendRequest = false;

// Runs a user-supplied callback safely.
function safeCallbackApply(name, request, callback, args) {
  try {
    $Function.apply(callback, request, args);
  } catch (e) {
    exceptionHandler.handle('Error in response to ' + name, e, request.stack);
  }
}

// Callback handling.
function handleResponse(requestId, name, success, responseList, error) {
  // The chrome objects we will set lastError on. Really we should only be
  // setting this on the callback's chrome object, but set on ours too since
  // it's conceivable that something relies on that.
  var callerChrome = chrome;

  try {
    var request = requests[requestId];
    logging.DCHECK(request != null);

    // lastError needs to be set on the caller's chrome object no matter what,
    // though chances are it's the same as ours (it will be different when
    // calling API methods on other contexts).
    if (request.callback)
      callerChrome = natives.GetGlobal(request.callback).chrome;

    lastError.clear(chrome);
    if (callerChrome !== chrome)
      lastError.clear(callerChrome);

    if (!success) {
      if (!error)
        error = "Unknown error.";
      lastError.set(name, error, request.stack, chrome);
      if (callerChrome !== chrome)
        lastError.set(name, error, request.stack, callerChrome);
    }

    if (request.customCallback) {
      safeCallbackApply(name,
                        request,
                        request.customCallback,
                        $Array.concat([name, request, request.callback],
                                      responseList));
    } else if (request.callback) {
      // Validate callback in debug only -- and only when the
      // caller has provided a callback. Implementations of api
      // calls may not return data if they observe the caller
      // has not provided a callback.
      if (logging.DCHECK_IS_ON() && !error) {
        if (!request.callbackSchema.parameters)
          throw new Error(name + ": no callback schema defined");
        validate(responseList, request.callbackSchema.parameters);
      }
      safeCallbackApply(name, request, request.callback, responseList);
    }

    if (error && !lastError.hasAccessed(chrome)) {
      // The native call caused an error, but the developer might not have
      // checked runtime.lastError.
      lastError.reportIfUnchecked(name, callerChrome, request.stack);
    }
  } finally {
    delete requests[requestId];
    lastError.clear(chrome);
    if (callerChrome !== chrome)
      lastError.clear(callerChrome);
  }
}

function prepareRequest(args, argSchemas) {
  var request = {};
  var argCount = args.length;

  // Look for callback param.
  if (argSchemas.length > 0 &&
      argSchemas[argSchemas.length - 1].type == "function") {
    request.callback = args[args.length - 1];
    request.callbackSchema = argSchemas[argSchemas.length - 1];
    --argCount;
  }

  request.args = [];
  for (var k = 0; k < argCount; k++) {
    request.args[k] = args[k];
  }

  return request;
}

// Send an API request and optionally register a callback.
// |optArgs| is an object with optional parameters as follows:
// - customCallback: a callback that should be called instead of the standard
//   callback.
// - forIOThread: true if this function should be handled on the browser IO
//   thread.
// - preserveNullInObjects: true if it is safe for null to be in objects.
// - stack: An optional string that contains the stack trace, to be displayed
//   to the user if an error occurs.
function sendRequest(functionName, args, argSchemas, optArgs) {
  calledSendRequest = true;
  if (!optArgs)
    optArgs = {};
  var request = prepareRequest(args, argSchemas);
  request.stack = optArgs.stack || exceptionHandler.getExtensionStackTrace();
  if (optArgs.customCallback) {
    request.customCallback = optArgs.customCallback;
  }

  var hasCallback = request.callback || optArgs.customCallback;
  var requestId =
      natives.StartRequest(functionName, request.args, hasCallback,
                           optArgs.forIOThread, optArgs.preserveNullInObjects);
  request.id = requestId;
  requests[requestId] = request;
}

function getCalledSendRequest() {
  return calledSendRequest;
}

function clearCalledSendRequest() {
  calledSendRequest = false;
}

exports.$set('sendRequest', sendRequest);
exports.$set('getCalledSendRequest', getCalledSendRequest);
exports.$set('clearCalledSendRequest', clearCalledSendRequest);
exports.$set('safeCallbackApply', safeCallbackApply);

// Called by C++.
exports.$set('handleResponse', handleResponse);

})

//---------------------------------------------------------------------------

(function(define, require, requireNative, requireAsync, exports, console, privates,$Array, $Function, $JSON, $Object, $RegExp, $String, $Error) {'use strict';// Copyright 2014 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.

// Handles uncaught exceptions thrown by extensions. By default this is to
// log an error message, but tests may override this behaviour.
var handler = function(message, e) {
  console.error(message);
};

/**
 * Append the error description and stack trace to |message|.
 *
 * @param {string} message - The prefix of the error message.
 * @param {Error|*} e - The thrown error object. This object is potentially
 *   unsafe, because it could be generated by an extension.
 * @param {string=} priorStackTrace - The stack trace to be appended to the
 *   error message. This stack trace must not include stack frames of |e.stack|,
 *   because both stack traces are concatenated. Overlapping stack traces will
 *   confuse extension developers.
 * @return {string} The formatted error message.
 */
function formatErrorMessage(message, e, priorStackTrace) {
  if (e)
    message += ': ' + safeErrorToString(e, false);

  var stack;
  try {
    // If the stack was set, use it.
    // |e.stack| could be void in the following common example:
    // throw "Error message";
    stack = $String.self(e && e.stack);
  } catch (e) {}

  // If a stack is not provided, capture a stack trace.
  if (!priorStackTrace && !stack)
    stack = getStackTrace();

  stack = filterExtensionStackTrace(stack);
  if (stack)
    message += '\n' + stack;

  // If an asynchronouse stack trace was set, append it.
  if (priorStackTrace)
    message += '\n' + priorStackTrace;

  return message;
}

function filterExtensionStackTrace(stack) {
  if (!stack)
    return '';
  // Remove stack frames in the stack trace that weren't associated with the
  // extension, to not confuse extension developers with internal details.
  stack = $String.split(stack, '\n');
  stack = $Array.filter(stack, function(line) {
    return $String.indexOf(line, 'chrome-extension://') >= 0;
  });
  return $Array.join(stack, '\n');
}

function getStackTrace() {
  var e = {};
  $Error.captureStackTrace(e, getStackTrace);
  return e.stack;
}

function getExtensionStackTrace() {
  return filterExtensionStackTrace(getStackTrace());
}

/**
 * Convert an object to a string.
 *
 * @param {Error|*} e - A thrown object (possibly user-supplied).
 * @param {boolean=} omitType - Whether to try to serialize |e.message| instead
 *   of |e.toString()|.
 * @return {string} The error message.
 */
function safeErrorToString(e, omitType) {
  try {
    return $String.self(omitType && e.message || e);
  } catch (e) {
    // This error is exceptional and could be triggered by
    // throw {toString: function() { throw 'Haha' } };
    return '(cannot get error message)';
  }
}

/**
 * Formats the error message and invokes the error handler.
 *
 * @param {string} message - Error message prefix.
 * @param {Error|*} e - Thrown object.
 * @param {string=} priorStackTrace - Error message suffix.
 * @see formatErrorMessage
 */
exports.$set('handle', function(message, e, priorStackTrace) {
  message = formatErrorMessage(message, e, priorStackTrace);
  handler(message, e);
});

// |newHandler| A function which matches |handler|.
exports.$set('setHandler', function(newHandler) {
  handler = newHandler;
});

exports.$set('getStackTrace', getStackTrace);
exports.$set('getExtensionStackTrace', getExtensionStackTrace);
exports.$set('safeErrorToString', safeErrorToString);

})

//---------------------------------------------------------------

(function(define, require, requireNative, requireAsync, exports, console, privates,$Array, $Function, $JSON, $Object, $RegExp, $String, $Error) {'use strict';// Copyright 2014 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.

var createClassWrapper = requireNative('utils').createClassWrapper;
var nativeDeepCopy = requireNative('utils').deepCopy;
var schemaRegistry = requireNative('schema_registry');
var CHECK = requireNative('logging').CHECK;
var DCHECK = requireNative('logging').DCHECK;
var WARNING = requireNative('logging').WARNING;

/**
 * An object forEach. Calls |f| with each (key, value) pair of |obj|, using
 * |self| as the target.
 * @param {Object} obj The object to iterate over.
 * @param {function} f The function to call in each iteration.
 * @param {Object} self The object to use as |this| in each function call.
 */
function forEach(obj, f, self) {
  for (var key in obj) {
    if ($Object.hasOwnProperty(obj, key))
      $Function.call(f, self, key, obj[key]);
  }
}

/**
 * Assuming |array_of_dictionaries| is structured like this:
 * [{id: 1, ... }, {id: 2, ...}, ...], you can use
 * lookup(array_of_dictionaries, 'id', 2) to get the dictionary with id == 2.
 * @param {Array<Object<?>>} array_of_dictionaries
 * @param {string} field
 * @param {?} value
 */
function lookup(array_of_dictionaries, field, value) {
  var filter = function (dict) {return dict[field] == value;};
  var matches = array_of_dictionaries.filter(filter);
  if (matches.length == 0) {
    return undefined;
  } else if (matches.length == 1) {
    return matches[0]
  } else {
    throw new Error("Failed lookup of field '" + field + "' with value '" +
                    value + "'");
  }
}

function loadTypeSchema(typeName, defaultSchema) {
  var parts = $String.split(typeName, '.');
  if (parts.length == 1) {
    if (defaultSchema == null) {
      WARNING('Trying to reference "' + typeName + '" ' +
              'with neither namespace nor default schema.');
      return null;
    }
    var types = defaultSchema.types;
  } else {
    var schemaName = $Array.join($Array.slice(parts, 0, parts.length - 1), '.');
    var types = schemaRegistry.GetSchema(schemaName).types;
  }
  for (var i = 0; i < types.length; ++i) {
    if (types[i].id == typeName)
      return types[i];
  }
  return null;
}

/**
 * Takes a private class implementation |cls| and exposes a subset of its
 * methods |functions| and properties |properties| and |readonly| in a public
 * wrapper class that it returns. Within bindings code, you can access the
 * implementation from an instance of the wrapper class using
 * privates(instance).impl, and from the implementation class you can access
 * the wrapper using this.wrapper (or implInstance.wrapper if you have another
 * instance of the implementation class).
 * @param {string} name The name of the exposed wrapper class.
 * @param {Object} cls The class implementation.
 * @param {{superclass: ?Function,
 *          functions: ?Array<string>,
 *          properties: ?Array<string>,
 *          readonly: ?Array<string>}} exposed The names of properties on the
 *     implementation class to be exposed. |superclass| represents the
 *     constructor of the class to be used as the superclass of the exposed
 *     class; |functions| represents the names of functions which should be
 *     delegated to the implementation; |properties| are gettable/settable
 *     properties and |readonly| are read-only properties.
 */
function expose(name, cls, exposed) {
  var publicClass = createClassWrapper(name, cls, exposed.superclass);

  if ('functions' in exposed) {
    $Array.forEach(exposed.functions, function(func) {
      publicClass.prototype[func] = function() {
        var impl = privates(this).impl;
        return $Function.apply(impl[func], impl, arguments);
      };
    });
  }

  if ('properties' in exposed) {
    $Array.forEach(exposed.properties, function(prop) {
      $Object.defineProperty(publicClass.prototype, prop, {
        enumerable: true,
        get: function() {
          return privates(this).impl[prop];
        },
        set: function(value) {
          var impl = privates(this).impl;
          delete impl[prop];
          impl[prop] = value;
        }
      });
    });
  }

  if ('readonly' in exposed) {
    $Array.forEach(exposed.readonly, function(readonly) {
      $Object.defineProperty(publicClass.prototype, readonly, {
        enumerable: true,
        get: function() {
          return privates(this).impl[readonly];
        },
      });
    });
  }

  return publicClass;
}

/**
 * Returns a deep copy of |value|. The copy will have no references to nested
 * values of |value|.
 */
function deepCopy(value) {
  return nativeDeepCopy(value);
}

/**
 * Wrap an asynchronous API call to a function |func| in a promise. The
 * remaining arguments will be passed to |func|. Returns a promise that will be
 * resolved to the result passed to the callback or rejected if an error occurs
 * (if chrome.runtime.lastError is set). If there are multiple results, the
 * promise will be resolved with an array containing those results.
 *
 * For example,
 * promise(chrome.storage.get, 'a').then(function(result) {
 *   // Use result.
 * }).catch(function(error) {
 *   // Report error.message.
 * });
 */
function promise(func) {
  var args = $Array.slice(arguments, 1);
  DCHECK(typeof func == 'function');
  return new Promise(function(resolve, reject) {
    args.push(function() {
      if (chrome.runtime.lastError) {
        reject(new Error(chrome.runtime.lastError));
        return;
      }
      if (arguments.length <= 1)
        resolve(arguments[0]);
      else
        resolve($Array.slice(arguments));
    });
    $Function.apply(func, null, args);
  });
}

exports.$set('forEach', forEach);
exports.$set('loadTypeSchema', loadTypeSchema);
exports.$set('lookup', lookup);
exports.$set('expose', expose);
exports.$set('deepCopy', deepCopy);
exports.$set('promise', promise);

})

//------------------------------------------------------------------------

