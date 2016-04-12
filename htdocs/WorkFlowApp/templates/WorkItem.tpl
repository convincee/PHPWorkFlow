{* Smarty *}
{* @todo - fix this - get rid of v - all because of col scope -  *}
{if !isset($subtable)}
  {assign var="subtable" value=false}
{/if}
<table border="2" width="100%">
  <tr>
    {if !$subtable}
      {foreach from=$cols item="col"}
        {if $col|substr:-1 != '_'}
          <th>{$col|escape}</th>
        {/if}
      {/foreach}
    {/if}
  </tr>
  {foreach from=$data item="workItem"}
    {if $subtable}
      <tr bgcolor="{cycle values="#dedede,#eeeeee" advance=false}">
        {foreach from=$workItem item="entry" key="heading"}
          <td nowrap>{$entry}</td>
        {/foreach}

        <td>
          {if $workItem.TransitionType == 'user'}
            <a href="{$SCRIPT_NAME}?action=triggerWorkItem&TransitionTriggerMethod={$workItem.TransitionTriggerMethod}&UseCaseId={$workItem.UseCaseId_}&focus={$focus}">Trigger</a>
          {else}
            NA
          {/if}
        </td>
      </tr>
    {else}
      <tr bgcolor="{cycle values="#dedede,#eeeeee" advance=false}">
        {foreach from=$cols item="col"}

          {if $col|substr:-1 != '_'}
            <td nowrap>{$workItem.$col}</td>
          {/if}
        {/foreach}

        <td>
          {if $workItem.TransitionType == 'user'}
            <a href="{$SCRIPT_NAME}?action=triggerWorkItem&TransitionTriggerMethod={$workItem.TransitionTriggerMethod}&UseCaseId={$workItem.UseCaseId_}&focus={$focus}">Trigger</a>
          {else}
            NA
          {/if}
        </td>

      </tr>
    {/if}
    {foreachelse}
    <tr>
      <td colspan="2">No records (and-join???? Or perchance an unfinished child??)</td>
    </tr>
  {/foreach}
</table>
