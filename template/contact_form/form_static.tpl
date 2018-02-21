<div class="gm-block-form">
		<div class="form-element">
			<div class="element-name">{$oLanguage->getMessage("Ваше имя")}{$sZir}</div>
			<input class="form-control grey" type="text" name=data[name] value="{$smarty.request.data.name}">
		</div>
		<div class="form-element">
			<div class="element-name">{$oLanguage->getMessage("Ваш e-mail")}{$sZir}</div>
			<input class="form-control grey" type="text" name=data[email] value="{$smarty.request.data.email}">
		</div>
		<div class="form-element">
			<div class="element-name">{$oLanguage->getMessage("Номер вашего телефона")}</div>
			<input class="form-control grey phone" type="text" name=data[phone] value="{$smarty.request.data.phone}">
		</div>
		<div class="form-element">
			<div class="element-name">{$oLanguage->getMessage("Тема")}</div>
			<input class="form-control grey" type="text" name=data[subject] value="{$smarty.request.data.subject}">
		</div>
		<div class="form-element">
			<div class="element-name">{$oLanguage->getMessage("Capcha field")}{$sZir}</div>
			{$sCapcha}
		</div>

		<div class="form-element">
			<div class="element-name">{$oLanguage->getMessage("Ваш запрос")}</div>
			<textarea class="form-control" name=data[description]>{$smarty.request.data.description}</textarea>
		</div>


	<div class="submit">
		<button type="submit" name="submitMessage" id="submitMessage" class="button btn btn-default button-medium">
			<span>
				{$oLanguage->getMessage("Send")}
				<i class="icon-chevron-right right"></i>
			</span>
		</button>
	</div>
</div>
<br>
<br>