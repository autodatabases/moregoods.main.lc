<?php /* Smarty version 2.6.18, created on 2017-05-19 15:20:42
         compiled from manager/form_distribute.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'manager/form_distribute.tpl', 5, false),)), $this); ?>
<table width=700 border=0 class="gm-block-order-filter no-mobile">
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('id_dist'); ?>
:</td>
		<td class="sel">
		<?php echo smarty_function_html_options(array('name' => 'search_dist','options' => $this->_tpl_vars['aNameDistr'],'selected' => $_REQUEST['search_dist'],'id' => 'select_name_user3','style' => "width: 196px;  max-width: 270px; "), $this);?>

			<script type="text/javascript">
	    <?php echo '
	    $(document).ready(function() {
		    $("#select_name_user3").searchable({
		    maxListSize: 50,
		    maxMultiMatch: 25,
		    wildcards: true,
		    ignoreCase: true,
		    latency: 10,
		    '; ?>
warnNoMatch: '<?php echo $this->_tpl_vars['oLanguage']->getMessage('no matches'); ?>
 ...',<?php echo '
		    zIndex: \'auto\'
		    });
	    });
	    '; ?>

	    </script>
		</td>
		<?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('user_debt'); ?>
:</td>
		<td class="sel">
		
		<?php echo smarty_function_html_options(array('name' => 'search_login','options' => $this->_tpl_vars['aNameUser'],'selected' => $_REQUEST['search_login'],'id' => 'select_name_user2','style' => "width: 160px; max-width: 270px;"), $this);?>

		<script type="text/javascript">
    <?php echo '
    $(document).ready(function() {
	    $("#select_name_user2").searchable({
	    maxListSize: 50,
	    maxMultiMatch: 25,
	    wildcards: true,
	    ignoreCase: true,
	    latency: 10,
	    '; ?>
warnNoMatch: '<?php echo $this->_tpl_vars['oLanguage']->getMessage('no matches'); ?>
 ...',<?php echo '
	    zIndex: \'auto\'
	    });
    });
    '; ?>

    </script>
		</td><?php endif; ?>
		
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('is_debt'); ?>
:</td>
		<td>
		<div class="options">
		<select class="js-uniform" id="menu_select" name='search[is_debt]' >
    		<option value=''>Все</option>
    		<option <?php if ($_REQUEST['search']['is_debt'] == 'is'): ?> selected <?php endif; ?> value='is'>Есть долг</option>
		</select>
		</div>
		</td>
	</tr>
</table>