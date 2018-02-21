<?php /* Smarty version 2.6.18, created on 2018-02-07 16:30:19
         compiled from addon/mpanel/drop_down/id.tpl */ ?>
<a href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_edit&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&move_up=1" onclick="
xajax_process_browse_url(this.href); return false;">
	 <img border=0 width=9 height=8 src="/libp/mpanel/images/small/arr2.gif"  hspace=3 align=absmiddle  alt="Move up"></a><br />
<a href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_edit&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&move_down=1" onclick="
xajax_process_browse_url(this.href); return false;">
	<img border=0 width=9 height=8 src="/libp/mpanel/images/small/arr3.gif"  hspace=3 align=absmiddle alt="Move down"></a>
<b><?php echo $this->_tpl_vars['aRow']['nice_num']; ?>
</b>