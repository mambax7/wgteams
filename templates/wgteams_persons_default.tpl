<div class="table-responsive">
    <table class="person-table table <{$person.rel_tablestyle}>">
        <tbody>
        <{if $person.person_image}>
            <tr>
                <td class="person-img center" colspan="2"><img class="img-responsive center <{$person.rel_imagestyle}>"
                                                               src="<{$person.person_image_url}><{$person.person_image}>"
                                                               alt="<{$person.person_name}>"
                                                               title="<{$person.person_name}>"></td>
            </tr>
        <{/if}>
        <tr>
            <td class="person-label right"><{$smarty.const._MA_WGTEAMS_PERSON_NAME}></td>
            <td class="person-text person-name"><{$person.person_name}></td>
        </tr>
        <{if $person.person_address}>
            <tr>
                <td class="person-label right"><{$smarty.const._MA_WGTEAMS_PERSON_ADDRESS}></td>
                <td class="person-text person-address"><{$person.person_address}></td>
            </tr>
        <{/if}>
        <{if $person.person_phone}>
            <tr>
                <td class="person-label right"><{$smarty.const._MA_WGTEAMS_PERSON_PHONE}></td>
                <td class="person-text person-phone"><{$person.person_phone}></td>
            </tr>
        <{/if}>
        <{if $person.person_email}>
            <tr>
                <td class="person-label right"><{$smarty.const._MA_WGTEAMS_PERSON_EMAIL}></td>
                <td class="person-text person-email"><{$person.person_email}></td>
            </tr>
        <{/if}>
        <{if $person.info_1 || $person.info_1_name}>
            <tr>
                <td class="person-label right"><{$person.info_1_name}></td>
                <td class="person-text person-info"><{$person.info_1}></td>
            </tr>
        <{/if}>
        <{if $person.info_2 || $person.info_2_name}>
            <tr>
                <td class="person-label right"><{$person.info_2_name}></td>
                <td class="person-text person-info"><{$person.info_2}></td>
            </tr>
        <{/if}>
        <{if $person.info_3 || $person.info_3_name}>
            <tr>
                <td class="person-label right"><{$person.info_3_name}></td>
                <td class="person-text person-info"><{$person.info_3}></td>
            </tr>
        <{/if}>
        <{if $person.info_4 || $person.info_4_name}>
            <tr>
                <td class="person-label right"><{$person.info_4_name}></td>
                <td class="person-text person-info"><{$person.info_4}></td>
            </tr>
        <{/if}>
        <{if $person.info_5 || $person.info_5_name}>
            <tr>
                <td class="person-label right"><{$person.info_5_name}></td>
                <td class="person-text person-info"><{$person.info_5}></td>
            </tr>
        <{/if}>
        </tbody>
    </table>
</div>
