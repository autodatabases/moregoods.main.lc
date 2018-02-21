{*<div class="element">
  <div class="date">
      <div class="day">{$oContent->GetMonthDay($aRow.date)}</div>
      {$oContent->GetYear($aRow.date)}
  </div>
  <div class="news-item">
      <a href="/pages/news/{$aRow.id}">{$aRow.short}</a>
  </div>
  <div class="clear"></div>
</div>
*}
<li class="news-element" style="display: inline-block;">
                <div class="image"><a href="/pages/news/{$aRow.id}"><img src="{$aRow.image}" alt="" style="max-width: 366px;max-height: 166px"></a></div>
                <div class="date">{$oContent->GetMonthDay($aRow.date)} {$oContent->GetYear($aRow.date)}</div>
                <div class="name"><a href="/pages/news/{$aRow.id}">{$aRow.page_description}</a></div>
                <div class="description">{$aRow.short}</div>
</li>
