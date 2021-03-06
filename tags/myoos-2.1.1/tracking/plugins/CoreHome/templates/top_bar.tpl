{assignTopBar}

<div id="topLeftBar">
{foreach from=$topBarElements item=element}
	<span class="topBarElem">{if $element.0 == $currentModule}<b>{else}<a href="{$element.2|@urlRewriteWithParameters}" {if isset($element.3)}{$element.3}{/if}>{/if}{$element.1}{if $element.0 == $currentModule}</b>{else}</a>{/if}</span>
{/foreach}
{postEvent name="template_topBar"} 
</div>

<div id="topRightBar">
<nobr>
<small>
{'General_HelloUser'|translate:"<strong>$userLogin</strong>"}
{if isset($userHasSomeAdminAccess) && $userHasSomeAdminAccess}| <a href='?module=CoreAdminHome'>{'General_Settings'|translate}</a>{/if} 
 {if $showSitesSelection && $showWebsiteSelectorInUserInterface}| {include file=CoreHome/templates/sites_selection.tpl}{/if}
| {if $userLogin == 'anonymous'}<a href='?module={$loginModule}'>{'Login_LogIn'|translate}</a>{else}<a href='?module={$loginModule}&amp;action=logout'>{'Login_Logout'|translate}</a>{/if}
</small>

</nobr>
</div>

<br clear="all" />
