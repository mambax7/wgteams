<table class="person-table table <{$person.rel_tablestyle}>">
    <tr>
        <td class="person-label left"><{$smarty.const._MA_WGTEAMS_PERSON_NAME}></td>
        <td class="person-text person-name"><{$person.person_name}></td>
        <{if $person.person_image}>
            <td class="person-img center" rowspan="<{$person.rel_nb_infos}>"><img
                        class="img-responsive center <{$person.rel_imagestyle}>"
                        src="<{$person.person_image_url}><{$person.person_image}>"
                        alt="<{$person.person_name}>" title="<{$person.person_name}>"></td>
        <{/if}>
    </tr>
    <{if $person.person_address}>
        <tr>
            <td class="person-label left"><{$smarty.const._MA_WGTEAMS_PERSON_ADDRESS}></td>
            <td class="person-text person-address"><{$person.person_address}></td>
        </tr>
    <{/if}>
    <{if $person.person_phone}>
        <tr>
            <td class="person-label left"><{$smarty.const._MA_WGTEAMS_PERSON_PHONE}></td>
            <td class="person-text person-phone"><{$person.person_phone}></td>
        </tr>
    <{/if}>
    <{if $person.person_email}>
        <tr>
            <td class="person-label left"><{$smarty.const._MA_WGTEAMS_PERSON_EMAIL}></td>
            <td class="person-text person-email"><{$person.person_email}></td>
        </tr>
    <{/if}>
    <{if $person.info_1_name || $person.info_1}>
        <tr>
            <td class="person-label left"><{$person.info_1_name}></td>
            <td class="person-text person-info"><{$person.info_1}></td>
        </tr>
    <{/if}>
    <{if $person.info_2_name || $person.info_2}>
        <tr>
            <td class="person-label left"><{$person.info_2_name}></td>
            <td class="person-text person-info"><{$person.info_2}></td>
        </tr>
    <{/if}>
    <{if $person.info_3_name || $person.info_3}>
        <tr>
            <td class="person-label left"><{$person.info_3_name}></td>
            <td class="person-text person-info"><{$person.info_3}></td>
        </tr>
    <{/if}>
    <{if $person.info_4_name || $person.info_4}>
        <tr>
            <td class="person-label left"><{$person.info_4_name}></td>
            <td class="person-text person-info"><{$person.info_4}></td>
        </tr>
    <{/if}>
    <{if $person.info_5_name || $person.info_5}>
        <tr>
            <td class="person-label left"><{$person.info_5_name}></td>
            <td class="person-text person-info"><{$person.info_5}></td>
        </tr>
    <{/if}>

</table>
