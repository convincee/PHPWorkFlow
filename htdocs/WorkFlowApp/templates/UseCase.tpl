{* Smarty *}

<table border="2" width="100%">
  <tr>
    <th colspan="100%" bgcolor="#d1d1d1">
      UseCase Entries (<a href="{$SCRIPT_NAME}?action=addUseCase">add</a>)
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
      <td>
        <table width="60" border="1" >
          <tr>
            <td nowrap ><a href="{$SCRIPT_NAME}?action=deleteUseCase&UseCaseId={$entry.UseCaseId_}&focus=UseCase">Delete</a></td>
            <td nowrap ><a href="{$SCRIPT_NAME}?action=downloadPNML&WorkFlowId={$entry.WorkFlowId_}&UseCaseId={$entry.UseCaseId_}&focus=UseCase">Generate PNML</a></td>
            <td nowrap ><a href="{$SCRIPT_NAME}?action=pushUseCase&WorkFlowId={$entry.WorkFlowId_}&UseCaseId={$entry.UseCaseId_}&focus=UseCase">Push UseCase</a></td>
          </tr>
        </table>
      </td>
    </tr>
    {foreachelse}
    <tr>
      <td colspan="2">No records</td>
    </tr>
  {/foreach}
</table>
