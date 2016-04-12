{* Smarty *}

<form action="{$SCRIPT_NAME}?action=submitTriggerFulfillment&focus=TriggerFulfillment"  enctype="multipart/form-data"  method="post">
  <table border="1">
    {if $error ne ""}
      <tr>
      <td bgcolor="yellow" colspan="2">
        {if $error eq "name_empty"}You must supply a name.
        {elseif $error eq "comment_empty"} You must supply a comment.
        {/if}
      </td>
      </tr>
    {/if}
    <tr>
      <td>UseCase Name:{$UseCaseName}</td>
      <td>
        <input type="hidden" name="UseCaseId" size="40" value="{$UseCaseId}">
      </td>
    </tr>
    <tr>
      <td>UseCase TriggerFulfillment:</td>
      <td>
        {html_options name=TransitionId options=$TransitionOptions selected=$TransitionDefaultSelect}
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" value="Submit">
      </td>
    </tr>
  </table>
</form>
