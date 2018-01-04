<{foreach item=person from=$persons}>
<{if $person.person_image}>
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
    <div class="person-img"><p><img class="img-responsive" src="<{$person.person_image_url}><{$person.person_image}>"
                                    alt="<{$person.person_name}>" title="<{$person.person_name}>"></div>
</div>
<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
    <{else}>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <{/if}>
        <div class="person-name"><{$person.person_name}></div>
    </div>
    <{/foreach}>
