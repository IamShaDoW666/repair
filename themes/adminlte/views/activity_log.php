<section class="box">
    <div class="box-body">
            <div class="table-responsive">
                <table class="table table-responsive-md table-striped mb-0" id="dynamic-table">
                    <thead>
                        <th></th>
                        <th><?= lang('log_action'); ?></th>
                        <th><?= lang('log_model'); ?></th>
                        <th><?= lang('log_link_id'); ?></th>
                        <th><?= lang('log_user_id'); ?></th>
                        <th><?= lang('log_timestamp'); ?></th>
                        <th><?= lang('log_ip_addr'); ?></th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?=$assets;?>plugins/renderjson.js"></script>
<script type="text/javascript" src="<?=base_url();?>panel/misc/js/log"></script>
<script type="text/javascript" src="<?=$assets;?>plugins/yadcf/jquery.dataTables.yadcf.js"></script>
