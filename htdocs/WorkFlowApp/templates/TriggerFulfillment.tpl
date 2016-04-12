{* Smarty *}

<table border="2" width="100%">
  <tr>
    {foreach from=$cols item="col"}
      <th>{$col|escape}</th>
    {/foreach}
  </tr>
  {foreach from=$data item="entry"}
    <tr bgcolor="{cycle values="#dedede,#eeeeee" advance=false}">
      {foreach from=$cols item="col"}
        <td nowrap>{$entry[$col]}</td>
      {/foreach}
      <td nowrap><a href="{$SCRIPT_NAME}?action=addTriggerFulfillment&UseCaseId={$entry.UseCaseId}">Add to this UseCase</a></td>
      <td nowrap><a href="{$SCRIPT_NAME}?action=deleteTriggerFulfillment&TriggerFulfillmentId={$entry.TriggerFulfillmentId}&focus=TriggerFulfillment">Delete</a></td>
    </tr>
    {foreachelse}
    <tr>
      <td colspan="2">No records</td>
    </tr>
  {/foreach}
</table>