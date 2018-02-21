<tr>
<td>{$oLanguage->getDMessage('Video File')}:</td>
<td>

     <table><tr>
        <td noWrap>
        <input type=text name=data[video_file] id='video_file_input' value='{$aData.video_file}' style='width:230px;'>
        <img hspace=1 align=absmiddle src='/libp/mpanel/images/small/inbox.png'>
        	<a href=#
        	onclick="javascript:OpenFileBrowser('/libp/mpanel/imgmanager/browser/default/browser.php?Type=Image&Connector=php_connector/connector.php&return_id=video_file&section=video', 600, 400); return false;"
				style='font-weight:normal'>Change</a></td>

     </table>
</td>
</tr>