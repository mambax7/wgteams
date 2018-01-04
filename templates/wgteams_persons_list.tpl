<table class="table <{$persons[0].rel_tablestyle}>">
    <tbody>
    <tr>
        <{foreach item=person from=$persons}>
        <{if $person.rel_nb_cols == 2}>
        <td class="width50">
            <{elseif $person.rel_nb_cols == 3}>
        <td class="width33">
            <{elseif $person.rel_nb_cols == 4}>
        <td class="width">
            <{else}>
            <{/if}>
            <{if $person.rel_displaystyle == 'left'}>
                <{include file='db:wgteams_persons_left.tpl' person=$person}>
            <{elseif $person.rel_displaystyle == 'right'}>
                <{include file='db:wgteams_persons_right.tpl' person=$person}>
            <{else}>
                <{include file='db:wgteams_persons_default.tpl' person=$person}>
            <{/if}>
        </td>
        <{if $member.rel_nb_cols != 0 && $person.rel_counter % $person.rel_nb_cols == 0}>
    </tr>
    <tr>
        <{/if}>
        <{/foreach}>
    </tr>
    </tbody>
</table>
