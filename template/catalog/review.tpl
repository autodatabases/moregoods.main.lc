<td>
                                <div class="element {if $aRow.parent_id}short{/if}">
                                    <div class="user-name">
                                    	{if $aRow.type == 'manager'}{$oLanguage->getMessage('rewiew shop stuff')} {else}<nobr>{$aRow.name}</nobr>{/if}
                                    </div>
                                    <div class="body">
                                        <div class="user-info">
                                            <img src="/image/design/user-icon.png" alt="">
                                            <div class="date">
                                                {$aRow.post|date_format:"%d.%m.%Y"}
                                            </div>
                                            <div class="tgp-rating-sub">
                                                <span style="width: {$aRow.stars}%"></span>
                                            </div>
                                        </div>
                                        <div class="comment-text">
                                            {$aRow.text}
                                            <br />
                                            {if $aAuthUser.type_=='manager'}
                                            <a class="answer" 
                                            onclick="xajax_process_browse_url('/?action=catalog_review_edit&data[id]={$aRow.id}&data[ref]={$sRef}');$('.js-add-comment-form').slideToggle(150);return false;"  
                                            href="#">
												{$oLanguage->getMessage("reply")}
											</a> 
											
											<a class="answer" onclick="xajax_process_browse_url('/?action=catalog_review_edit&data[id]={$aRow.id}&data[ref]={$sRef}&data[edit]=1');$('.js-add-comment-form').slideToggle(150);return false;"  href="#">
											<img title="{$oLanguage->getMessage("edit")}" src="/image/design/edit.png"></a> 
											
											<a class="answer" onclick="if (confirm('{$oLanguage->getMessage("confirm remove review")}')) 
											xajax_process_browse_url('/?action=catalog_review_remove&id={$aRow.id}'); return false;" href="#">
											<img src="/image/delete.png" alt="remove"></a>
											{/if}
                                        </div>
                                    </div>
                                </div>

</td>