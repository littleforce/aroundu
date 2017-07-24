<template>
<div id="carousel">
  <el-carousel :interval="4000" type="card" height="300px">
    <el-carousel-item v-for="url in urls" :key="url">
      <img :src='url' style="height: inherit;">
    </el-carousel-item>
  </el-carousel>
</div>
</template>

<script>
export default {
  name: 'carousel',
  data () {
    return {
      urls: [
        "http://localhost/storage/5382de3448fce0c34ff14e601713312f/QJQcap4ETgrFu3zP4xfFYpavq4tU2oCtcydUt1pW.jpeg",
        "http://localhost/storage/5382de3448fce0c34ff14e601713312f/QJQcap4ETgrFu3zP4xfFYpavq4tU2oCtcydUt1pW.jpeg",
        "http://localhost/storage/5382de3448fce0c34ff14e601713312f/QJQcap4ETgrFu3zP4xfFYpavq4tU2oCtcydUt1pW.jpeg",
        "http://localhost/storage/5382de3448fce0c34ff14e601713312f/QJQcap4ETgrFu3zP4xfFYpavq4tU2oCtcydUt1pW.jpeg",
        "http://localhost/storage/5382de3448fce0c34ff14e601713312f/QJQcap4ETgrFu3zP4xfFYpavq4tU2oCtcydUt1pW.jpeg",
      ],
    }
  },
}
</script>

<style>
  .el-carousel__item {
    color: #475669;
    font-size: 14px;
    opacity: 1;
    line-height: 100px;
    text-align: center;
    margin: 0;
  }

  .el-carousel__item:nth-child(2n) {
    background-color: transparent;
  }

  .el-carousel__item:nth-child(2n+1) {
    background-color: transparent;
  }
</style>