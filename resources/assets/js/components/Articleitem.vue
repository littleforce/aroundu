<template>
    <div id="articleitem">
        <hr>
        <el-row v-if="article_image != 'isok'">
            <el-col :span='18'>
                <div class="author">
                    <div class="name">
                        <img class="avatar" :src="user_avatar" style="border-radius:1000px; height: 40px; width: 40px;">
                        <div class="info">
                            <a :href="'/user/'+user_id">{{ user_name }} </a>
                            <span> {{ article_created_at }}</span>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <p class="title"><a :href="'/article/'+article_id">{{article_title}}</a></p>
                    <p class="abstract">{{ article_content }}</p>
                </div>
                <div class="meta">
                    <span><i class="iconfont icon-like"></i>{{ article_votes_count }}</span>
                    <span><i class="iconfont icon-comment"></i>{{ article_comments_count }}</span>
                </div>
            </el-col>
            <el-col :span='4'>
                <div>
                    <img class='image' :src="article_image">
                </div>
            </el-col>
        </el-row>
        <el-row v-else>
            <el-col :span='24'>
                <div class="author">
                    <div class="name">
                        <img class="avatar" :src="user_avatar" style="border-radius:1000px; height: 40px; width: 40px;">
                        <div class="info">
                            <a :href="'/user/'+user_id">{{ user_name }} </a>
                            <span> {{ article_created_at }}</span>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <p class="title"><a :href="'/article/'+article_id">{{article_title}}</a></p>
                    <p class="abstract">{{ article_content }}</p>
                </div>
                <div class="meta">
                    <span><i class="iconfont icon-like"></i>{{ article_votes_count }}</span>
                    <span><i class="iconfont icon-comment"></i>{{ article_comments_count }}</span>
                </div>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        name: 'articleitem',
        data () {
            return {
                user_url: '/user/'+this.user_id,
            }
        },
        props: [
            'user_id', 'user_name', 'user_avatar',
            'article_id', 'article_title', 'article_content',
            'article_votes_count', 'article_comments_count',
            'article_image', 'article_created_at'
        ],
    }
</script>

<style type="text/css">
    .name .info{
        vertical-align: middle;
        display: inline-block;
    }
    .name a + span{
        display: block;
    }
    .author {
        margin-bottom: 5px;
    }
    .avatar {
        vertical-align: middle;
        border: 1px solid #dedada;
        border-radius: 50%;
    }
    .title {
        margin: -7px 0 0px;
        display: inherit;
        font-size: 25px;
        font-weight: 900;
        line-height: 1.5;
    }
    .content {
        font-weight: 700;
        margin-left: 5px;
    }
    .abstract {
        margin: 0 0 8px;
        font-size: 13px;
        line-height: 24px;
    }
    .iconfont {
        font-size: 25px;
    }
    .meta {
        opacity:0.5;
    }
    .image {
        border-radius: 5px;
        margin-top: 28px;
        margin-left: 6px;
        height: 100px;
        width: 150px;
    }
    hr {
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>