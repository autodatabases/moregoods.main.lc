/*
 * jQuery inline editor v 0.1.4 by Maki
 * http://maki.com.ua
 *
 * Dbl click - open editor, than:
 * Click  'close' icon  to close editor and restore original text
 * Click <enter> in editor to save changes
 * 
 * Code is free for use and modifications.
 *
   <div class="editable" 
   method="save_user_name" 
   key="123" 
   [type="select|text"] 
   [dataprovider="provider_json_get_all"]
   [datakey="current-id-in-text"]>
        old_value
   </div>

 * send: http://yousite/inlineEditor/save
 *           ?action=save_user_name
 *           &key=123
 *           &value=new_value
 *      new_value - from input editor
 *
    <script type="text/javascript">
    $(document).ready(function(){
    $('.editable').inlineEditor({
                            //error dialog if result!=true
                        error:          function(e, data) { alert('Error: \r\n'+data); },
                            //save confirmation dialog
                        save:           function(e, data) { return confirm('save changes ?'); },
                            //show or not save confirmation dialog
                        saveDialog:     false,
                            //show or not error dialogs (error response and ajax error)
                        errorDialog:    false,
                            //required! url to send request to
                        url:            '/inlineEditor/save',
                        	//path where find 2 icons: edit.png + close.png
                       	path:			'/libp/jquery/inline',
                            //request type
                        type:           'POST'
		});
    });
    </script>
 *
 * min style:
                $('.editable').inlineEditor({
                        url:  '/inlineEditor/save',
                      	path: '/libp/jquery/inline',
		});
 *
 * yii controller (as example):
 *
    class InlineEditorController extends CController {
        public function actionSave($action, $key, $value) {
            return $this->renderText('true');
        }
    }
 *
 */
//redraw function
(function($){
    $.fn.extend({
        inlineEditorLabel: function(p) {
    		sectionObject = this.html("<nobr></nobr>");
    		if(p.color)
    			sectionObject=sectionObject.css('background-color',p.color);
    		return sectionObject.find('nobr')
    		.text(p.text)
    		.append("<img src='"+p.path+"/edit.png'>");
    	}	
    });
})(jQuery);

(function($){
    $.fn.extend({
        inlineEditorEdit: function(p) {
    		var obj = $(this);
    		var inputType = obj.attr('type')?obj.attr('type'):'text';
    		//-20 correct image width!
    		var w = (obj.width()-20)>0 ? (obj.width()-20) : 20 ;
    		
    		var sectionObj = obj.html("<nobr></nobr>").find('nobr');
    		if(inputType=='text'){
    			sectionObj=sectionObj.html("<input type='text' value='"+p.value+"' style='width:"+w+"px;'/>")
    			.find('input').unbind('keypress').focus().keypress(function(event){
    				//key press for input
                    if (event.keyCode == '13' && $.isFunction(p.handler)){
                    	sectionObj.attr('disabled','disabled');
                    	p.handler.call(sectionObj,null,$(this).val());
                    }
    			});
    		}else if(inputType=='select'){
    				sectionObj=sectionObj.html("<select style='width:"+w+"px;'/>");
    			    $.getJSON("/?action="+p.dataprovider,{ajax: 'true'}, function(j){
    			      var options = '';
    			      for (var i = 0; i < j.length; i++) {
    			        options += '<option value="' + j[i].id + '">' + j[i].value + '</option>';
    			      }
    			      sectionObj.find('select').html(options);
    			      var a=1;
    			      sectionObj.find('select').find('option').each(function() {
                          if ($(this).val() == obj.attr('datakey') ) {
                                  $(this).attr('selected', 'selected');
                          }
                      });
    			    });
    			
    			    sectionObj.find('select').unbind('change').change(function(event){
    			    	sectionObj.find('select').attr('disabled','disabled');
    			    	var value = sectionObj.find('option:selected').text();
    			    //	alert("v: "+value);
    			    	p.handler.call(sectionObj,null,sectionObj.find('option:selected').val()
    			    			,sectionObj.find('option:selected').text());
    			    });
    		}else{
    			sectionObj=sectionObj.html("##error##");
    		}
    		return sectionObj;
    	}	
    });
})(jQuery);


(function($){
    $.fn.extend({
        inlineEditor: function(options) {

            var defaults = {
            	path:			'',
                url:			'',
                error:          function(e, data) { alert('Error: \r\n'+data); },
                save:           function(e, data) { return confirm('save changes ?'); },
                callback:		'',
                saveDialog:     false,
                errorDialog:    false,
                type:           'POST'
            };

            var options = $.extend(defaults, options);

            return this.each(function() {
                var obj = $(this);
                obj.value=obj.text();
                obj.inlineEditorLabel({text:obj.value,path:options.path});
                
                obj.dblclick(function(){
                	
                	obj.inlineEditorEdit({
                	   value:obj.value,
                	   datakey:obj.attr('datakey')?obj.attr('datakey'):'-1',
                	   dataprovider:obj.attr('dataprovider')?obj.attr('dataprovider'):'none',
                	   handler:function(e,newValue,newLabel){
                		//alert('newValue'+newValue);
                		//obj.find('input').attr('disabled','disabled');
                        //var input=$(event.target);
                        var param = {
                            value:     obj.attr('sendlabel')?newLabel:newValue,
                            method:    obj.attr('method')?obj.attr('method'):'none',
                            key:       obj.attr('key')?obj.attr('key'):'',
                            ajax:	  true
                        };
//                        alert(param.value);
//                        return;

                        if (!options.saveDialog ||
                       ($.isFunction(options.save) && options.save.call(obj, event, param)) !== false ) {
                        	
                               $.ajax({
                                 url:      options.url,
                                 data:     param,
                                 type:     options.type,
                                 cache:    false,
                                 success: function(data){                                   
                                   var color = '#F7FF9F';
                                   if(data=='true'){
                                	   if(obj.attr('reload'))
                                  		  history.go(0);
                                	   if(newLabel!=null)
                                		   obj.value = newLabel;
                                	   else
                                		   obj.value = newValue;                                                  
                                   }else{
                                       if($.isFunction(options.error) && options.errorDialog)
                                               options.error.call(obj, null, data);
                                       color = obj.css('background-color');
                                   }
                                   obj.inlineEditorLabel({text:obj.value,path:options.path,color:color});
                                 },error: function(e,text){
                                	 alert('eee');
                                           if(options.errorDialog)
                                               alert('Script error. Url not available.');
                                           obj.inlineEditorLabel({text:obj.value,path:options.path});
                                 }
                               });
                           };
                	}});
                	
                      //draw cancel button with redraw handler
		              obj.find('nobr').append("<img src='"+options.path+"/cancel.png'>")
		              .find('img')
		              .click(function(){
		            	  obj.inlineEditorLabel({text:obj.value,path:options.path});
		              });
                  });
                
          });
        }
    });
})(jQuery);

$(document).ready(function(){
    $('.editable').inlineEditor({
    					saveDialog:		false,
                        errorDialog:    true,
                        path:			'/libp/jquery/inline',
                        url:            '/?action=inline_editor_save',
                        type:           'POST'
		});
});