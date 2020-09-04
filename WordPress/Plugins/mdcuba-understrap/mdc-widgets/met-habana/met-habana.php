    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>
    <script src="https://kit.fontawesome.com/3acc335195.js" crossorigin="anonymous"></script>
    <script src="<?php echo plugin_dir_url( __FILE__ ) .'inc/wws.js' ?>"></script>
    <script src="<?php echo plugin_dir_url( __FILE__ ) .'inc/wwi.js' ?>"></script>

<div id="met-hab">
    
    <div class="alert alert-info" role="alert">
        <div v-if="!data">
            <h5>Cargando el pronóstico....</h5>        
        </div>
        <div v-else>
            <h6>Minimas de <b>{{data.minTemp}}&deg;C</b> y máximas de <b>{{data.maxTemp}}&deg;C</b></h6>
            <h4><wwi v-bind:wep="data.weather"></wwi> -  <b><wws v-bind:wep="data.weather"></wws> </h4>
        </div>
        
    </div>

</div>


<script>
new Vue ({
    el: '#met-hab',
    data() {
        return {
            data: null
            }
    },
    mounted () {
        axios
        .get('<?php echo plugin_dir_url( __FILE__ )."inc/curl-request.php" ?>')
        .then(response => (this.data = response.data.city.forecast.forecastDay[1])); 
     }
});

</script>