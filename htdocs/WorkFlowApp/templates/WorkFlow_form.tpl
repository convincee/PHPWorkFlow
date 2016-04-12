{* Smarty *}

<form action="{$SCRIPT_NAME}?action=submitWorkFlow&focus=WorkFlow"  enctype="multipart/form-data" method="post">
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
      <td>PNML File:</td>
      <td>
        <input type="file" name="datafile"  id="datafile" size="40">
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" value="Submit">
      </td>
    </tr>
  </table>
</form>
