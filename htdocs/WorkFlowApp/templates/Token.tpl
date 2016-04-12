{* Smarty *}

<table border="2" width="100%">
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
      {$emptyArr = []}
      {if $col == 'PotentialWorkItems' }
      <td>{include file="WorkItem.tpl" data=$entry.$col subtable=true focus="Token"}</td>
      {else}
      <td nowrap>{$entry.$col}
        {/if}
        {/if}
        {/foreach}
    </tr>
    {foreachelse}
    <tr>
      <td colspan="2">No records</td>
    </tr>
  {/foreach}
</table>
