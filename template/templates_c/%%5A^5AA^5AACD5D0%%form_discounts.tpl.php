<?php /* Smarty version 2.6.18, created on 2017-07-09 12:52:28
         compiled from manager/form_discounts.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'manager/form_discounts.tpl', 6, false),)), $this); ?>
<table width=700 border=0 class="gm-block-order-filter ">
	<tr>

		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('id_brand_group'); ?>
:</td>
		<td class="sel4">
		<?php echo smarty_function_html_options(array('name' => 'search_brand_group','options' => $this->_tpl_vars['aNameBrandGroup'],'selected' => $_REQUEST['search_brand_group'],'id' => 'select_name_user4','style' => 'width:160px;padding: 8px 8px 8px 10px;height: 40px;'), $this);?>

			<script type="text/javascript">
	    <?php echo '
	    $(document).ready(function() {
		    $("#select_name_user4").searchable({
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
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('id_dist'); ?>
:</td>
		<td class="sel4">
		<?php echo smarty_function_html_options(array('name' => 'search_dist','options' => $this->_tpl_vars['aNameDistr'],'selected' => $_REQUEST['search_dist'],'id' => 'select_name_user3','style' => 'width:160px;padding: 8px 8px 8px 10px;height: 40px;'), $this);?>

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
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Group'); ?>
:</td>
		<td>
		<select name='search_group' style='width:130px;padding: 8px 8px 8px 10px;height: 40px;'>
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aGroupsG'],'selected' => $_REQUEST['search_group']), $this);?>

			</select>
		</td>
		
		<?php endif; ?>
</tr>
<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('id_brand'); ?>
:</td>
		<td class="sel4">
		<?php echo smarty_function_html_options(array('name' => 'search_brand','options' => $this->_tpl_vars['aNameBrand'],'selected' => $_REQUEST['search_brand'],'id' => 'select_name_user5','style' => 'width:160px;padding: 8px 8px 8px 10px;height: 40px;'), $this);?>

			<script type="text/javascript">
	    <?php echo '
	    $(document).ready(function() {
		    $("#select_name_user5").searchable({
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
		<td class="sel4">
		
		<?php echo smarty_function_html_options(array('name' => 'search_login','options' => $this->_tpl_vars['aNameUser'],'selected' => $_REQUEST['search_login'],'id' => 'select_name_user2','style' => 'width:160px;padding: 8px 8px 8px 10px;height: 40px;'), $this);?>

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
		</td>
		
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('InList'); ?>
:</td>
		<td >
			<select name=search_list style='width:130px;padding: 8px 8px 8px 10px;height: 40px;'>
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aList'],'selected' => $_REQUEST['search_list']), $this);?>

			</select>
		</td>

		<?php endif; ?>
	</tr>
</table>