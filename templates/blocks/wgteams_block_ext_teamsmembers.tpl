<{if $block|default:false}>
    <div id="team" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 container-team">
        <{foreach item=team from=$block}>
            <div class="row"><{include file='db:wgteams_block_ext_teams_list.tpl' team=$team}></div>
        <{/foreach}>
    </div>
<{/if}>