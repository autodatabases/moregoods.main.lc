<div class="gm-block-userdata personal">
                <div class="caption">{$oLanguage->GetMessage('personal_data')}</div>
                <div class="user-data">
                    <span>{$oLanguage->GetMessage('contact_person')}</span><br />
                    {$aAuthUser.name}<br />
                    <br />
                    <span>{$oLanguage->GetMessage('Email')}</span><br />
                    <a href="mailto:{$aAuthUser.email}">{$aAuthUser.email}</a><br />
                    <br />
                    <span>{$oLanguage->GetMessage('phone')}</span><br />
                    +38{$aAuthUser.phone}<br />
                </div>
                <div class="user-data-edit">
                    <a href="/pages/customer_profile/" class="link-edit"><span class="gm-link-dashed">{$oLanguage->GetMessage('edit')}</span></a><br />
                    <a href="/pages/user_change_password/" class="link-password"><span class="gm-link-dashed">{$oLanguage->GetMessage('change_parol')}</span></a><br />
                    {*<a href="#" class="link-delete"><span class="gm-link-dashed">{$oLanguage->GetMessage('del_y')}</span></a><br />*}
                </div>
            </div>
            
