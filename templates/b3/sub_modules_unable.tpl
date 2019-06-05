<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
    <div class="well">
        <div class="row">
            <div class="col-xs-6 col-sm-5 col-md-4">
                <div>
                    <img src="<{$mod.logo}>" alt="<{$mod.name}>" style="width: 100%;" id="<{$mod.dirname}>_tip">
                </div>
                <div style="padding:6px;">
                    <{if $mod.version}>
                        <a href="<{$xoops_url}>/modules/<{$mod.dirname}>/admin/index.php" target="_blank" title="<{$mod.dirname}><{$smarty.const._MA_TADADM_MOD_ADMIN}>"><i class="fa fa-wrench"></i></a>

                        <a href="<{$xoops_url}>/modules/system/admin.php?fct=preferences&op=showmod&mod=<{$mod.mid}>" title="<{$mod.dirname}><{$smarty.const._MA_TADADM_MOD_PREF}>"><i class="fa fa-edit"></i></a>

                        <a href="<{$xoops_url}>/modules/system/admin.php?fct=modulesadmin&op=update&module=<{$mod.dirname}>&tad_adm_tpl=clean" title="<{$smarty.const._MA_TADADM_MODULES_UPDATING}><{$mod.dirname}>" class="modulesadmin" data-fancybox-type="iframe"><i class="fa fa-refresh" ></i></a>

                        <a href="<{$xoops_url}>/modules/<{$mod.dirname}>/admin/index.php" title="<{$mod.dirname}><{$smarty.const._MA_TADADM_MOD_BLOCK}>" target="_blank"><i class="fa fa-th" ></i></a>
                    <{/if}>
                </div>
            </div>
            <div class="col-xs-6 col-sm-7 col-md-8">
                <div style="font-size: 1.1em;">
                    <a href="https://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=<{$mod.module_sn}>" title="<{$mod.dirname}><{$smarty.const._MA_TADADM_MOD_ADMIN}>" target="_blank" style="font-weight: bold;">
                    <{$mod.name}></a>
                    <br>
                    <a href="<{$xoops_url}>/modules/<{$mod.dirname}>" target="_blank"><{$mod.dirname}></a>
                </div>

                <a href="#" class="btn btn-sm btn-block btn-default modulesadmin"  data-fancybox-type="iframe" title="<{$mod.dirname}> <{$mod.version}> (<{$mod.last_update}>) to <{$mod.new_version}> (<{$mod.new_last_update}>)" disabled><{$mod.status}></a>

                <div>
                    <{if isset($mod.fileowner.name)}>
                        <{$mod.fileowner.name}>:<{$mod.filegroup.name}>
                    <{/if}>
                    <{if $mod.fileperms=='0777'}>
                        <{$smarty.const._MA_TADADM_WRITABLE}>
                    <{else}>
                        <{$mod.fileperms}>
                    <{/if}>
                </div>
            </div>
        </div>
    </div>
</div>