{* Smarty *}

<form action="{$SCRIPT_NAME}?action=submitUseCase&focus=UseCase"  enctype="multipart/form-data"  method="post">
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
      <td>UseCase Name:</td>
      <td>
        <input type="text" name="Name" size="40">
      </td>
    </tr>
    <tr>
      <td>UseCase Description:</td>
      <td>
        <textarea name="Description" cols="40" rows="3">{}</textarea>
      </td>
    </tr>
    <tr>
      <td>UseCase WorkFlow:</td>
      <td>
        {html_options name=WorkFlowID options=$WorkFlowOptions selected=$WorkFlowDefaultSelect}
      </td>
    </tr>


    <tr>
      <td colspan="2" align="center">
        <input type="submit" value="Submit">
      </td>
    </tr>
  </table>
</form>
