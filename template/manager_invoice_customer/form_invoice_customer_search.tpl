<script src="/js/popcalendar.js"></script>

<table width=100% border=0 class="gm-block-order-filter no-mobile">
	<tr>
		<td>{$oLanguage->getMessage("Login")}:</td>
		<td><input type=text name=search[login] value='{$smarty.request.search.login}' maxlength=20 style='width:150px'>
		</td>
		<td>{$oLanguage->getMessage("fio")}:</td>
		<td><input type=text name=search[fio] value='{$smarty.request.search.fio}' maxlength=20 style='width:150px'>
		</td>
	</tr>
	<tr>
		<td>{$oLanguage->getMessage("IsEnd")}:</td>
		<td>{html_options name='search[is_end]' options=$aIsEnd selected=$smarty.request.search.is_end style='width:150px'}</td>
	</tr>
	<tr>
		<td>По дате</td>
                <td><input class="date" name=search[datestart] style='width:150px' id=datestart type="text" value="{$smarty.request.search.datestart}"></td>
                <td>&nbsp; -</td>
                <td><input class="date" name=search[dateend] style='width:150px' id=dateend type="text" value="{$smarty.request.search.dateend}"></td>
                <input class="js-date" type="text" name="search[date]" value="" style="display: none;">
	</tr>
	<tr>
		<td>{$oLanguage->getMessage("Id")}:</td>
		<td><input type=text name=search[id] value='{$smarty.request.search.id}' maxlength=20 style='width:150px'></td>

		<td>{$oLanguage->getMessage("post manager")}:</td>
		<td>{html_options name=search[post_manager] style='width:150px' options=$aPostManager
			selected=$smarty.request.search.post_manager}</td>
	</tr>
</table>