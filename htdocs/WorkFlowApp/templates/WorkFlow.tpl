{* Smarty *}

<table border="2" width="100%">
  <tr>
    <th colspan="100%" bgcolor="#d1d1d1">
      WorkFlow Entries (<a href="{$SCRIPT_NAME}?action=addWorkFlow">add</a>)
    </th>
  </tr>
  <tr>
    {foreach from=$cols item="col"}
      {if $col|substr:-1 != '_'}
        <th>{$col|escape}</th>
      {/if}
    {/foreach}
  </tr>
  {foreach from=$data item="entry"}
    <tr bgcolor="{cycle values="#dedede,#eeeeee" advance=false}">
      {foreach from=$cols item="col"}
        {if $col|substr:-1 != '_'}
          <td nowrap>{$entry.$col}</td>
        {/if}
      {/foreach}
      <td nowrap><a href="{$SCRIPT_NAME}?action=deleteWorkFlow&WorkFlowId={$entry.WorkFlowId_}">Delete</a></td>
      <td nowrap><a href="{$SCRIPT_NAME}?action=downloadPNML&WorkFlowId={$entry.WorkFlowId_}">Generate PNML</a></td>
    </tr>
    {foreachelse}
    <tr>
      <td colspan="2">No records</td>
    </tr>
  {/foreach}
</table>
