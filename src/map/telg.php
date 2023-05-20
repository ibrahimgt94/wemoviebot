<?php

# start cmd
xroute()->node->main->base->cmd
    ->rule("start")->targ("show_cmd");

# start glass
xroute()->node->main->glass->sole
    ->rule("back.main")->targ("show_gls");

xroute()->node->main->glass->sole
    ->rule("profile")->targ("profile_gls");

xroute()->node->main->glass->query
    ->type("gps.show.cmd")->dbs("groups", "id")
    ->targ("group_map_gls")->args("chunk", 2)->args("take", 9);

xroute()->node->main->glass->sole
    ->rule("gps.show.cmd.page.next")->targ("group_map_gls");

xroute()->node->main->glass->sole
    ->rule("gps.show.cmd.page.prev")->targ("group_map_gls");

xroute()->node->main->glass->sole
    ->rule("back.group.x2")->targ("group_map_gls")
    ->args("chunk", 2)->args("take", 9);

# query movie_gps all
xroute()->node->main->glass->query->type("movie_gls")
    ->dbs("movies", "id")->targ("movie_gls");

xroute()->node->main->glass->sole
    ->rule("movie_gls.page.next")->targ("movie_gls");

xroute()->node->main->glass->sole
    ->rule("movie_gls.page.prev")->targ("movie_gls");

xroute()->node->main->glass->sole
    ->rule("back.movie")->targ("movie_gls");

# back to movie_gps
xroute()->node->main->glass->sole
    ->rule("back.movie")->targ("movie_gls");

xroute()->node->main->glass->sole
    ->rule("movie_gls.page.next")->targ("group_map_gls");

xroute()->node->main->glass->sole
    ->rule("movie_gls.page.prev")->targ("group_map_gls");

# query down_gps all
xroute()->node->main->glass->query->type("down_gls")
    ->targ("down_gls")->dbs("movies", "id");

xroute()->node->main->glass->sole
    ->rule("down_gls.page.next")->targ("down_gls");

xroute()->node->main->glass->sole
    ->rule("down_gls.page.prev")->targ("down_gls");

# proposed btn
xroute()->node->main->glass->sole
    ->rule("proposed")->targ("proposed_gls");

# popular btn
xroute()->node->main->glass->sole
    ->rule("popular")->targ("popular_gls");

# help btn
xroute()->node->main->glass->sole
    ->rule("help")->targ("help_gls");

# support btn
xroute()->node->main->glass->sole
    ->rule("support")->targ("support_gls");

# search btn
xroute()->node->main->glass->sole
    ->rule("search")->targ("search_gls");

xroute()->node->main->base->save
    ->rule("search.movie")->targ("search_proc_gls");

# panel
xroute()->node->panel->glass->sole
    ->rule("show")->targ("show_gls");

xroute()->node->panel->glass->sole
    ->rule("back.panel")->targ("show_gls");

# panel_user
xroute()->node->panel_user->glass->sole
    ->rule("user")->targ("show_gls");

xroute()->node->panel_user->glass->query->type("info_gls")
    ->dbs("users", "id")->targ("info_gls");

xroute()->node->panel_user->glass->sole
    ->rule("info_gls.page.next")->targ("info_gls");

xroute()->node->panel_user->glass->sole
    ->rule("info_gls.page.prev")->targ("info_gls");

xroute()->node->panel_group->glass->sole
    ->rule("info_gls.page.next")->targ("info_gls");

xroute()->node->panel_group->glass->sole
    ->rule("info_gls.page.prev")->targ("info_gls");

# back to movie_gps
xroute()->node->panel_user->glass->sole
    ->rule("back.user")->targ("show_gls");

xroute()->node->panel_user->glass->sole
    ->rule("user.search")->targ("search_gls");

xroute()->node->panel_user->glass->sole
    ->rule("user.search.id")->targ("search_id_gls");

xroute()->node->panel_user->base->save
    ->rule("user.search.id")->targ("search_id_proc_gls");

xroute()->node->panel_user->glass->sole
    ->rule("user.search.username")->targ("search_username_gls");

xroute()->node->panel_user->base->save
    ->rule("user.search.username")->targ("search_username_proc_gls");

xroute()->node->panel_user->glass->sole
    ->rule("back.user.search")->targ("search_gls");

xroute()->node->panel_user->glass->sole
    ->rule("user.notice.all")->targ("notice_all_gls");

xroute()->node->panel_user->glass->query
    ->type("notice_all_gls")->dbs("notices", "id")
    ->targ("notice_all_chg_gls");

xroute()->node->panel_user->glass->sole
    ->rule("back.user.notice.all")->targ("notice_all_gls");

xroute()->node->panel_user->glass->sole
    ->rule("notice.all.confirm")->targ("notice_all_proc_gls");

xroute()->node->panel_user->glass->sole
    ->rule("notice.all.cancel")->targ("notice_all_gls");

xroute()->node->panel_user->glass->sole
    ->rule("notice")->targ("notice_gls");

xroute()->node->panel_user->glass->query
    ->type("notice_gls")->dbs("notices", "id")
    ->targ("notice_chg_gls");

xroute()->node->panel_user->glass->sole
    ->rule("back.user.notice")->targ("notice_gls");

xroute()->node->panel_user->glass->sole
    ->rule("notice.chg.cancel")->targ("notice_gls");

xroute()->node->panel_user->glass->sole
    ->rule("notice.chg.confirm")->targ("notice_proc_gls");

xroute()->node->panel_user->glass->sole
    ->rule("coin")->targ("coin_gls");

xroute()->node->panel_user->glass->pack
    ->pack("increase", "decrease")->targ("coin_among_gls");

xroute()->node->panel_user->glass->sole
    ->rule("back.user.coin")->targ("coin_gls");

xroute()->node->panel_user->glass->sole
    ->rule("back.user.coin.among")->targ("coin_among_gls");

xroute()->node->panel_user->glass->among->rule("coin_among_gls")
    ->among(1, 8)->targ("coin_proc_gls");

xroute()->node->panel_user->glass->sole
    ->rule("back.user.info")->targ("info_gls");

xroute()->node->panel_user->glass->sole
    ->rule("status")->targ("status_gls");

xroute()->node->panel_user->glass->sole
    ->rule("back.user.status")->targ("status_gls");

xroute()->node->panel_user->glass->pack
    ->pack("status.enable", "status.disable")->targ("status_proc_gls");





# panel_group
xroute()->node->panel_group->glass->sole
    ->rule("group")->targ("show_gls");

# back to panel_group
xroute()->node->panel_group->glass->sole
    ->rule("back.group")->targ("show_gls");

xroute()->node->panel_group->glass->sole
    ->rule("search")->targ("search_gls");

xroute()->node->panel_group->glass->sole
    ->rule("list")->targ("list_gls");

xroute()->node->panel_group->glass->sole
    ->rule("back.list")->targ("list_gls");

xroute()->node->panel_group->glass->query
    ->type("list_gls")->dbs("groups", "id")
    ->targ("list_chg_gls");

xroute()->node->panel_group->glass->sole
    ->rule("delete")->targ("delete_gls");

xroute()->node->panel_group->glass->sole
    ->rule("status")->targ("status_gls");

xroute()->node->panel_group->glass->sole
    ->rule("parent")->targ("parent_gls");

xroute()->node->panel_group->glass->sole
    ->rule("edite")->targ("edite_gls");

xroute()->node->panel_group->glass->sole
    ->rule("list.status.enable")->targ("status_proc_gls");

xroute()->node->panel_group->glass->sole
    ->rule("list.status.disable")->targ("status_proc_gls");

xroute()->node->panel_group->glass->sole
    ->rule("back.list.status")->targ("status_gls");

xroute()->node->panel_group->glass->sole
    ->rule("list_gls.page.next")->targ("list_gls");

xroute()->node->panel_group->glass->sole
    ->rule("list_gls.page.prev")->targ("list_gls");

xroute()->node->panel_group->glass->sole
    ->rule("add")->targ("add_gls");

xroute()->node->panel_group->glass->sole
    ->rule("back.list.chg")->targ("list_chg_gls");

xroute()->node->panel_group->glass->sole
    ->rule("list.delete.confirm")->targ("delete_proc_gls");

xroute()->node->panel_group->base->save
    ->rule("group.add.name")->targ("add_save_name_gls");

xroute()->node->panel_group->glass->sole
    ->rule("confirm")->targ("add_show_title_gls");

xroute()->node->panel_group->base->save
    ->rule("group.add.title")->targ("add_save_title_gls");

xroute()->node->panel_group->glass->sole
    ->rule("confirm.two")->targ("add_show_desc_gls");

xroute()->node->panel_group->base->save
    ->rule("group.add.desc")->targ("add_save_desc_gls");

xroute()->node->panel_group->glass->sole
    ->rule("confirm.three")->targ("add_parent_gls");

xroute()->node->panel_group->glass->query
    ->type("add.parent")->dbs("groups", "id")
    ->targ("add_status_gls");

xroute()->node->panel_group->glass->sole
    ->rule("add.parent.page.next")->targ("add_parent_gls");

xroute()->node->panel_group->glass->sole
    ->rule("add.parent.page.prev")->targ("add_parent_gls");

xroute()->node->panel_group->glass->sole
    ->rule("empty")->targ("add_status_gls");

xroute()->node->panel_group->glass->sole
    ->rule("disable")->targ("add_create_gls");

xroute()->node->panel_group->glass->sole
    ->rule("enable")->targ("add_create_gls");

xroute()->node->panel_group->glass->sole
    ->rule("confirm.for")->targ("add_create_proc_gls");

xroute()->node->panel_group->glass->query
    ->type("list_parent_gls")->dbs("groups", "id")
    ->targ("parent_proc_gls");

xroute()->node->panel_group->glass->sole
    ->rule("list_parent_gls.page.next")->targ("parent_gls");

xroute()->node->panel_group->glass->sole
    ->rule("list_parent_gls.page.prev")->targ("parent_gls");

xroute()->node->panel_group->glass->sole
    ->rule("list.parent.empty")->targ("parent_proc_gls");

xroute()->node->panel_group->glass->sole
    ->rule("list.edite.name")->targ("edite_name_gls");

xroute()->node->panel_group->glass->sole
    ->rule("list.edite.title")->targ("edite_title_gls");

xroute()->node->panel_group->glass->sole
    ->rule("list.edite.desc")->targ("edite_desc_gls");

xroute()->node->panel_group->glass->sole
    ->rule("back.list.edit")->targ("edite_gls");

xroute()->node->panel_group->base->save
    ->rule("edite.name.gls")->targ("edite_name_proc_gls");

xroute()->node->panel_group->base->save
    ->rule("edite.title.gls")->targ("edite_title_proc_gls");

xroute()->node->panel_group->base->save
    ->rule("edite.desc.gls")->targ("edite_desc_proc_gls");

xroute()->node->panel_group->base->save
    ->rule("list.search.by.name.gls")->targ("search_by_name_proc_gls");

xroute()->node->panel_group->base->save
    ->rule("list.search.by.title.gls")->targ("search_by_title_proc_gls");

xroute()->node->panel_group->glass->sole
    ->rule("search.by.name")->targ("search_by_name_gls");

xroute()->node->panel_group->glass->sole
    ->rule("search.by.title")->targ("search_by_title_gls");

xroute()->node->panel_group->glass->sole
    ->rule("back.search")->targ("search_gls");

# panel_movie
xroute()->node->panel_movie->glass->sole
    ->rule("movie")->targ("show_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("back.show")->targ("show_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("search")->targ("search_gls");

xroute()->node->panel_movie->base->save
    ->rule("movie.search")->targ("search_proc_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("list")->targ("list_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("sendsite")->targ("sendsite_gls");
    
xroute()->node->panel_movie->glass->sole
    ->rule("sendchannel")->targ("sendchannel_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("back.list")->targ("list_gls");

xroute()->node->panel_movie->glass->query
    ->type("list_gls")->dbs("movies", "id")
    ->targ("list_show_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("list_gls.page.next")->targ("list_show_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("list_gls.page.prev")->targ("list_show_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("back.add.draft")->targ("add_mory_draft_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("dels")->targ("dels_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("confirm.dels")->targ("dels_proc_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("image")->targ("image_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("title")->targ("title_gls");

xroute()->node->panel_movie->base->save
    ->rule("title.gls")->targ("title_proc_gls");

xroute()->node->panel_movie->base->save
    ->rule("image.gls")->targ("image_proc_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("summary")->targ("summary_gls");

xroute()->node->panel_movie->base->save
    ->rule("summary.gls")->targ("summary_proc_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("status")->targ("status_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("disable")->targ("status_proc_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("delete.addrs")->targ("down_delete_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("edit.title")->targ("down_edit_title_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("edit.down.add")->targ("down_add_addr_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("back.downs.show.title")->targ("down_edit_title_gls");

xroute()->node->panel_movie->glass->list_ary
    ->type("down_edit_title_gls", "down.title")
    ->targ("down_edit_title_proc_gls");

xroute()->node->panel_movie->glass->list_ary
    ->type("down_add_addr_gls", "down.title")
    ->targ("down_add_addr_two_gls");

xroute()->node->panel_movie->base->save
    ->rule("down.add.addr")->targ("down_add_addr_three_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("edit.addrs")->targ("down_edit_addrs_gls");

xroute()->node->panel_movie->base->save
    ->rule("edit.addrs")->targ("down_edit_addrs_proc_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("status.addrs")->targ("down_edit_status_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("status.addrs.disable")->targ("down_edit_status_proc_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("dowm.add.addr.confirm")->targ("down_add_addr_for_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("down.add.addr.enable")->targ("down_add_addr_fiv_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("down.add.addr.disable")->targ("down_add_addr_fiv_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("auto.down.add")->targ("down_auto_add_addr_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("dowm.add.addr.confirm.two")->targ("down_add_addr_proc_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("dowm.add.addr.confirm.two.auto")->targ("down_add_addr_auto_proc_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("status.addrs.enable")->targ("down_edit_status_proc_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("confirm.delete")->targ("down_delete_proc_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("enable")->targ("status_proc_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("back.downs.show.status")->targ("down_edit_status_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("back.list")->targ("list_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("back.list.show")->targ("list_show_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("back.downs")->targ("down_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("back.downs.show")->targ("down_show_gls");

xroute()->node->panel_movie->glass->query->type("down_gls")
    ->dbs("downs", "id")->targ("down_show_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("group")->targ("group_gls");

xroute()->node->panel_movie->glass->query
    ->type("group_gls")->dbs("groups", "id")
    ->targ("group_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("group_gls.page.next")->targ("group_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("group_gls.page.prev")->targ("group_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("down")->targ("down_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("property")->targ("property_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("back.list.property")->targ("property_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("property.director")->targ("director_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("property.producer")->targ("producer_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("property.writer")->targ("writer_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("property.year")->targ("year_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("property.filming")->targ("filming_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("property.singer")->targ("singer_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("property.actors")->targ("actors_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("property.duration")->targ("duration_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("property.asong")->targ("asong_gls");

xroute()->node->panel_movie->glass->query
    ->type("director_gls")->dbs("groups", "id")
    ->targ("director_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("director_gls.page.next")->targ("director_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("director_gls.page.prev")->targ("director_gls");

xroute()->node->panel_movie->glass->query
    ->type("producer_gls")->dbs("groups", "id")
    ->targ("producer_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("producer_gls.page.next")->targ("producer_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("producer_gls.page.prev")->targ("producer_gls");

xroute()->node->panel_movie->glass->query
    ->type("year_gls")->dbs("groups", "id")
    ->targ("year_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("year_gls.page.next")->targ("year_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("year_gls.page.prev")->targ("year_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("add")->targ("add_show_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("back.add.draft")->targ("add_show_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("back.add.draft.show")->targ("add_mory_draft_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("add.mory.draft")->targ("add_mory_draft_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("add.del.draft")->targ("add_del_draft_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("add.draft.del.data")->targ("add_draft_delete_gls");

xroute()->node->panel_movie->glass->sole
    ->rule("add.draft.save")->targ("add_draft_save_gls");

# back to panel_movie
xroute()->node->panel_group->glass->sole
    ->rule("back.movie")->targ("show_gls");

# panel_cog
xroute()->node->panel_cog->glass->sole
    ->rule("cog")->targ("show_gls");

# back to panel_cog
xroute()->node->panel_cog->glass->sole
    ->rule("back.cog")->targ("show_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("status")->targ("status_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("back.status")->targ("status_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("status.enable")->targ("status_proc_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("status.disable")->targ("status_proc_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("group")->targ("group_gls");

xroute()->node->panel_cog->glass->query
    ->type("group_gls")->dbs("groups", "id")
    ->targ("group_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("group_gls.page.next")->targ("group_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("group_gls.page.prev")->targ("group_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("group_gls.page.next")->targ("group_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("group_gls.page.prev")->targ("group_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("downs")->targ("downs_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("back.downs")->targ("downs_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("subset")->targ("subset_gls");

xroute()->node->panel_cog->glass->status
    ->rule("subset.status")->sta_targ("subset_gls");

xroute()->node->panel_cog->glass->nums->among(1, 9)
    ->rule("subset.coin")->sta_targ("subset_gls");

xroute()->node->panel_cog->glass->nums->among(100, 900)
    ->rule("subset.coin.cost")->sta_targ("subset_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("support")->targ("support_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("help")->targ("help_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("back.support")->targ("support_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("back.help")->targ("help_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("channel")->targ("channel_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("back.channel")->targ("channel_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("back.channel.title")->targ("channel_title_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("back.channel.title.proc")->targ("channel_title_proc_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("back.channel.ps")->targ("channel_ps_gls");

xroute()->node->panel_cog->glass->select
    ->rule("channel.status.p1")->sta_targ("channel_gls")->args("type", "p1");

xroute()->node->panel_cog->glass->select
    ->rule("channel.status.p2")->sta_targ("channel_gls")->args("type", "p2");

xroute()->node->panel_cog->glass->sole
    ->rule("chunk")->targ("chunk_gls");

xroute()->node->panel_cog->glass->nums->among(1, 3)
    ->rule("rows.main.group")->sta_targ("chunk_rows_gls");

xroute()->node->panel_cog->glass->nums->among(1, 15)
    ->rule("chunk.main.group")->sta_targ("chunk_take_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("chunk.take")->targ("chunk_take_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("chunk.rows")->targ("chunk_rows_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("back.cog.chunk")->targ("chunk_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("channel.p1")->targ("channel_after_gls")->args("type", "p1");

xroute()->node->panel_cog->glass->sole
    ->rule("channel.p2")->targ("channel_after_gls")->args("type", "p2");

xroute()->node->panel_cog->base->save
    ->rule("channel.uniqid.title")->targ("channel_title_proc_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("back.chnl.after")->targ("channel_after_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("chnl.after.title")->targ("channel_title_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("chnl.after.addr")->targ("channel_ps_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("down.uploadboy")->targ("down_uploadboy_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("back.down.uploadboy")->targ("down_uploadboy_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("uploadboy.server")->targ("down_uploadboy_server_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("down.telegram")->targ("down_telegram_gls");

xroute()->node->panel_cog->glass->list_ary
    ->type("ups.boy.server", "ups.boy.server")
    ->targ("down_uploadboy_server_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("ups.boy.server.page.next")->targ("down_uploadboy_server_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("ups.boy.server.page.prev")->targ("down_uploadboy_server_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("uploadboy.username")->targ("down_uploadboy_username_gls");

xroute()->node->panel_cog->base->save
    ->rule("ups.boy.server.username")->targ("down_uploadboy_username_proc_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("uploadboy.password")->targ("down_uploadboy_password_gls");

xroute()->node->panel_cog->base->save
    ->rule("ups.boy.server.password")->targ("down_uploadboy_password_proc_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("down.ftp")->targ("down_ftp_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("down.ftp")->targ("down_ftp_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("ftp.server")->targ("down_ftp_server_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("back.down.ftp")->targ("down_ftp_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("ftp.username")->targ("down_ftp_username_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("ftp.password")->targ("down_ftp_password_gls");

xroute()->node->panel_cog->base->save
    ->rule("down.ftp.server")->targ("down_ftp_server_proc_gls");

xroute()->node->panel_cog->base->save
    ->rule("down.ftp.username")->targ("down_ftp_username_proc_gls");

xroute()->node->panel_cog->base->save
    ->rule("down.ftp.password")->targ("down_ftp_password_proc_gls");

xroute()->node->panel_cog->glass->sole
    ->rule("down.telegram")->targ("down_telegram_gls");

xroute()->node->panel_cog->base->save
    ->rule("down.telg.cha")->targ("down_telegram_proc_gls");

# args del
xroute()->node->panel_cog->glass->sole
    ->rule("channel.title.confirm")->targ("channel_ps_gls");

xroute()->node->panel_cog->base->save
    ->rule("support.uniqid")->targ("support_proc_gls");

xroute()->node->panel_cog->base->save
    ->rule("help.uniqid")->targ("help_proc_gls");

xroute()->node->panel_cog->base->save
    ->rule("channel.uniqid")->targ("channel_ps_proc_gls");

# panel_notice
xroute()->node->panel_notice->glass->sole
    ->rule("notice")->targ("show_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("add.notice")->targ("add_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("wait.notice")->targ("wait_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("back.wait.notice")->targ("wait_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("back.wait.notice.show")->targ("wait_show_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("user.job.show")->targ("wait_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("search.user.job")->targ("wait_search_gls");

xroute()->node->panel_notice->glass->query
    ->type("wait.gls")->dbs("queues", "id")
    ->targ("wait_show_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("wait.search")->targ("wait_search_gls");

xroute()->node->panel_notice->base->save
    ->rule("wait.search.gls")->targ("wait_search_proc_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("wait.resend")->targ("wait_resend_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("wait.resend.confirm")->targ("wait_resend_proc_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("wait.delete")->targ("wait_delete_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("wait.delete.confirm")->targ("wait_delete_proc_gls");

xroute()->node->panel_notice->glass->query
    ->type("edit.notice")->dbs("notices", "id")
    ->targ("edit_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("edit.title")->targ("edit_title_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("edit.delete")->targ("delete_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("delete.confirm")->targ("delete_proc_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("back.notice.edit.title")->targ("edit_title_gls");

xroute()->node->panel_notice->base->save
    ->rule("edit.title.gls")->targ("edit_title_proc_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("edit.body")->targ("edit_body_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("back.notice.edit.body")->targ("edit_body_gls");

xroute()->node->panel_notice->base->save
    ->rule("edit.body.gls")->targ("edit_body_proc_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("edit.status")->targ("edit_status_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("back.notice.edit.status")->targ("edit_status_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("back.notice")->targ("show_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("back.notice.edit")->targ("edit_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("edit.status.proc")->targ("edit_status_proc_gls");

xroute()->node->panel_notice->base->save
    ->rule("add.title.gls")->targ("add_title_gls");

xroute()->node->panel_notice->base->save
    ->rule("back.add.title.gls")->targ("add_title_gls");

xroute()->node->panel_notice->base->save
    ->rule("add.body.gls")->targ("add_body_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("add.status.proc")->targ("add_status_gls");

xroute()->node->panel_notice->glass->sole
    ->rule("add.confirm")->targ("add_save_gls");

# back to panel_notice
xroute()->node->panel_notice->glass->sole
    ->rule("back.notice")->targ("show_gls");