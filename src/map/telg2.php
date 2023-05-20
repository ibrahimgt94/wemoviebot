<?php

# start cmd
xroute()->node->main->base->cmd
    ->rule("start")->targ("show");

# start glass
xroute()->node->main->glass->sole
    ->rule("back.main")->targ("show2");

# director
xroute()->node->main->glass->pack->pages([
    "director", "back.group.director"
])->targ("groups")->args("page", 0)
    ->args("name", "director")->args("id", 4)
    ->args("chunk", 2)->args("take", 9);

# actor
xroute()->node->main->glass->pack->pages([
    "actor", "back.group.actor"
])->targ("groups")->args("page", 0)
    ->args("name", "actor")->args("id", 5)
    ->args("chunk", 2)->args("take", 9);

# year
xroute()->node->main->glass->pack->pages([
    "year", "back.group.year"
])->targ("groups")->args("page", 0)
    ->args("name", "year")->args("id", 7)
    ->args("chunk", 2)->args("take", 9);

# writer
xroute()->node->main->glass->pack->pages([
    "writer", "back.group.writer"
])->targ("groups")->args("page", 0)
    ->args("name", "writer")->args("id", 6)
    ->args("chunk", 2)->args("take", 9);

# query movie_gps all
xroute()->node->main->glass->query->type("movie_gps")
    ->dbs("movie", "id")->targ("movie_gps");

# back to movie_gps
xroute()->node->main->glass->sole
    ->rule("back.movie")->targ("movie_gps");

# query down_gps all
xroute()->node->main->glass->query->type("down_gps")
    ->targ("down_gps")->dbs("movies", "id");

# proposed btn
xroute()->node->main->glass->sole
    ->rule("proposed")->targ("proposed");

# popular btn
xroute()->node->main->glass->sole
    ->rule("popular")->targ("popular");

# help btn
xroute()->node->main->glass->sole
    ->rule("help")->targ("help");

# support btn
xroute()->node->main->glass->sole
    ->rule("support")->targ("support");

# search btn
xroute()->node->main->glass->sole
    ->rule("search")->targ("search");

# data search
xroute()->node->main->base->save
    ->rule("search2")->targ("data_search");

# panel
xroute()->node->main->glass->sole
    ->rule("panel")->targ("panel");

# back panel
xroute()->node->main->glass->sole
    ->rule("back.panel")->targ("panel");

# panel user btns
xroute()->node->panel->glass->sole
    ->rule("user")->targ("user");

# panel list user
xroute()->node->panel->glass->query->type("info_user")
    ->targ("info_user")->dbs("users", "id");

xroute()->node->panel->glass->sole->rule("coin")
    ->targ("info_user_coin");

xroute()->node->panel->glass->pack->pack("decrease", "increase")
    ->targ("info_user_coin_chg");

xroute()->node->panel->glass->among->rule("info_user_coin_proc")
    ->among(1, 8, 1)->targ("info_user_coin_proc");

xroute()->node->panel->glass->sole
    ->rule("status")->targ("info_user_status");

xroute()->node->panel->glass->pack
    ->pack("enable", "disable")->targ("info_user_status_proc");

# panel list movies
xroute()->node->panel->glass->sole
    ->rule("movie")->targ("movie");

# panel list groups
xroute()->node->panel->glass->sole
    ->rule("group")->targ("group");

# panel list cogs
xroute()->node->panel->glass->sole
    ->rule("cogs")->targ("cogs");