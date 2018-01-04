<!-- Header -->
<{include file='db:wgteams_admin_header.tpl'}>
<{if $persons_list}>
    <table class="table table-bordered  table-striped">
        <thead>
        <tr class="head">
            <th class="center"><{$smarty.const._AM_WGTEAMS_PERSON_ID}></th>
            <th class="center"><{$smarty.const._AM_WGTEAMS_PERSON_FIRSTNAME}></th>
            <th class="center"><{$smarty.const._AM_WGTEAMS_PERSON_LASTNAME}></th>
            <th class="center"><{$smarty.const._AM_WGTEAMS_PERSON_TITLE}></th>
            <th class="center"><{$smarty.const._AM_WGTEAMS_PERSON_ADDRESS}></th>
            <th class="center"><{$smarty.const._AM_WGTEAMS_PERSON_PHONE}></th>
            <th class="center"><{$smarty.const._AM_WGTEAMS_PERSON_EMAIL}></th>
            <th class="center"><{$smarty.const._AM_WGTEAMS_PERSON_IMAGE}></th>
            <th class="center"><{$smarty.const._AM_WGTEAMS_SUBMITTER}></th>
            <th class="center"><{$smarty.const._AM_WGTEAMS_DATE_CREATE}></th>
            <th class="center width5"><{$smarty.const._AM_WGTEAMS_FORM_ACTION}></th>
        </tr>
        </thead>
        <{if $persons_count}>
            <tbody><{foreach item=person from=$persons_list}>
                <tr class="<{cycle values='odd, even'}>">
                    <td class="center"><{$person.id}></td>
                    <td class="center"><{$person.firstname}></td>
                    <td class="center"><{$person.lastname}></td>
                    <td class="center"><{$person.title}></td>
                    <td class="center"><{$person.address}></td>
                    <td class="center"><{$person.phone}></td>
                    <td class="center"><{$person.email}></td>
                    <td class="center"><img src="<{$wgteams_upload_url}>/persons/images/<{$person.image}>" alt="persons"
                                            style='max-width:50px;'></td>
                    <td class="center"><{$person.submitter}></td>
                    <td class="center"><{$person.date_create}></td>
                    <td class="center  width5">
                        <a href="persons.php?op=edit&amp;person_id=<{$person.id}>" title="<{$smarty.const._EDIT}>"><img
                                    src="<{xoModuleIcons16 edit.png}>" alt="persons"></a>
                        <a href="persons.php?op=delete&amp;person_id=<{$person.id}>"
                           title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>"
                                                                  alt="persons"></a>
                    </td>
                </tr>
            <{/foreach}>
            </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
    <{if $pagenav}>
        <div class="xo-pagenav floatright"><{$pagenav}></div>
        <div class="clear spacer"></div>
    <{/if}>

<{/if}>
<{if $form}>
    <{$form}>
<{/if}>
<{if $error}>
    <div class="errorMsg"><strong><{$error}></strong>
    </div>
<{/if}>
<br>
<!-- Footer -->
<{include file='db:wgteams_admin_footer.tpl'}>
