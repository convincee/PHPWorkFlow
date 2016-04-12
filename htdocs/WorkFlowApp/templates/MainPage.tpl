<!DOCTYPE html>
<html lang="en">
<head>
    <title>PHPWorkFlow Tool</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</head>
<body>
<table border="2" width="200">
    <tr>
        <th colspan="100%" bgcolor="#d1d1d1">
            <a href="{$SCRIPT_NAME}">Home</a>
        </th>
    <tr>
    <tr>
        <th colspan="100%" bgcolor="#d1d1d1">
            WorkFlow Entries (<a href="{$SCRIPT_NAME}?action=addWorkFlow&focus=WorkFlow">add</a>)
        </th>
    <tr>
    </tr>
        <th colspan="100%" bgcolor="#d1d1d1">
            UseCase Entries (<a href="{$SCRIPT_NAME}?action=addUseCase&focus=UseCase">add</a>)
        </th>
    </tr>
</table>
<div class="container">
    <h2>Dynamic Tabs</h2>
    <ul class="nav nav-tabs">
        <li {if $focus =="WorkFlow"}class="active"{/if}><a data-toggle="tab" href="#home">WorkFlow</a></li>
        <li {if $focus == "UseCase"}class="active"{/if}><a data-toggle="tab" href="#menu1">UseCase(Open)</a></li>
        <li {if $focus == "UseCaseAll"}class="active"{/if}><a data-toggle="tab" href="#menu2">UseCase(All)</a></li>
        <li {if $focus == "WorkItem"}class="active"{/if}><a data-toggle="tab" href="#menu3">WorkItem (Enabled)</a></li>
        <li {if $focus == "Token"}class="active"{/if}><a data-toggle="tab" href="#menu4">Token (Free)</a></li>
        <li {if $focus == "TriggerFulfillment"}class="active"{/if}><a data-toggle="tab" href="#menu5">TriggerFulfillment (Enabled UseCases)</a></li>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade {if $focus == "WorkFlow"}in active{/if}">
            <h3>WorkFlow</h3>
            <p>{$work_flow_content}</p>
        </div>
        <div id="menu1" class="tab-pane fade {if $focus == "UseCase"}in active{/if}">
            <h3>UseCase (Open)</h3>
            <p>{$open_use_case_content}</p>
        </div>
        <div id="menu2" class="tab-pane fade {if $focus == "UseCaseAll"}in active{/if}">
            <h3>UseCase</h3>
            <p>{$all_use_case_content}</p>
        </div>
        <div id="menu3" class="tab-pane fade {if $focus == "WorkItem"}in active{/if}">
            <h3>WorkItem (Enabled)</h3>
            <p>{$enabled_work_item_content}</p>
        </div>
        <div id="menu4" class="tab-pane fade {if $focus == "Token"}in active{/if}">
            <h3>Token (Free)</h3>
            <p>{$enabled_token_content}</p>
        </div>
        <div id="menu5" class="tab-pane fade {if $focus == "TriggerFulfillment"}in active{/if}">
            <h3>TriggerFulfillment (Enabled UseCases)</h3>
            <p>{$trigger_fulfillment_content}</p>
        </div>
    </div>
</div>

</body>
</html>
