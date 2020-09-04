<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<?php
global $wpdb;
$tablename = $wpdb->prefix.'tdcubania';

//SQL table
    $sqln = "SELECT count(DISTINCT `ip_address`) FROM `$tablename`"; //Cuenta ip_address diferentes
    //$sqln = "SELECT count(*) FROM `$tablename`"; //Cuenta todo
    $ntest = $wpdb->get_var($sqln);
    
    //Array con los promedios por cada IP address
    $sqla = "SELECT avg(`pciento`) as ppp FROM `$tablename` group by `ip_address`";
    
    $proms = $wpdb->get_results($wpdb->prepare($sqla), ARRAY_A);
    $promp = [];
    foreach ($proms as $prom) {
         $promp[] = intval($prom['ppp']);
     }
    //Promedio de los promedios por cada IP
    $avtest = round(array_sum($promp)/$ntest);

//Fichero ajax
$ajaxfp = plugin_dir_url( __FILE__ ).'inc/tdc_ajax.php';

?>

<div id="tdc">
    <button v-if="!start" class="btn btn-primary" v-on:click="tdcs">Empezar el test</button>
    <!-- index is used to check with current question index -->
    <div v-show="start" v-for="(question, index) in quiz.questions">
      <!-- Hide all questions, show only the one with index === to current question index -->
      <div v-show="index === questionIndex">
        <p class="framed-box">Pregunta numero {{(index+1)}}: {{ question.text }}</p>
        <ul class="list-group list-group-flush list-group-horizontal-sm">
          <li class="list-group-item" v-for="response in question.responses">
            <label>
              <input type="radio" 
                     v-bind:value="response.correct" 
                     v-bind:name="index" 
                     v-model="userResponses[index]"> {{response.text}}
            </label>
          </li>
          </ul>
        <button class="btn btn-primary" v-on:click="next"v-if="questionIndex != quiz.questions.length - 1">
          Siguiente
        </button>
		<button class="btn btn-primary" v-else v-on:click="tdcres">
		Terminar test y ver resultados
		</button>
      </div>
    </div>
    <div v-show="questionIndex === quiz.questions.length">
      <div v-bind:class="balertc" role="alert">
            <img src="https://memoriasdecuba.blog/wp-content/uploads/2020/04/memorias-de-cuba-icon.png" class="float-right rounded-circle" style="width:8%">
            <strong>{{balertm}}</strong><p>Puntuaci&oacute;n final: {{ score() }} / {{ quiz.questions.length }}. Eres un {{pciento}}% cubano, seg&uacute;n este test.</p>
            <?php if($ntest > 5) { // Solo muestra la estadística si más de 10 han hecho el test ?>
            <p><strong><?php echo ($ntest) ?></strong> personas ya hab&iacute;an hecho el test....   El promedio hasta ahora era <strong><?php echo round($avtest) ?>%</strong></p>
            <?php } ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>
      <button class="btn btn-primary" v-on:click="tdri">Reiniciar el test</button>
    </div>
</div>

  <Script>

var quiz = {
  questions: [
    {
      text: "\u00BFA qu\u00E9 hora mataron a Lola?",
      responses: [
          { text: 'A las 9pm' }, 
          { text: 'A las 6am' }, 
          { text: 'A las 3pm', correct: true },  
      ]
    }, {
          text: "\u00BFQu\u00E9 le pasa al ni\u00F1o que no llora?",
      responses: [
          { text: 'No le dan leche' }, 
          { text: 'No mama', correct: true }, 
          { text: 'No le cambian el culero' }, 
      ]
      },
      {
          text: "A\u00E9, a\u00E9, a\u00E9 ... \u00BFqu\u00E9 cosa?",
          responses: [
              { text: 'La chambelona', correct: true },
              { text: 'Nos vamos pa la playa' },
              { text: 'La peste el \u00faltimo' },
          ]
      },
      {
          text: "\u00BFQu\u00E9 quiere el bobo de la yuca?",
          responses: [
              { text: 'Que lo inviten a la fiesta' },
              { text: 'Casarse', correct: true },
              { text: 'Comer gratis' },
          ]
        },
       {
           text: "\u00BFA qu\u00E9 se le da la patada?",
           responses: [
               { text: 'Al tambor' },
               { text: 'Al pesao' },
               { text: 'A la lata', correct: true },
           ]
        },
        {
            text: "Si voy al Cobre, \u00BFqu\u00E9 quieres que te traiga?",
            responses: [
                { text: 'Un crucifijo' },
                { text: 'Una virgencita', correct: true },
                { text: 'Un recuerdo' },
               
            ]
        },
        {
            text: "\u00BFDe qui\u00E9n era el platanal?",
            responses: [
                { text: 'De La Negra Tomasa' },
                { text: 'De Bartolo', correct: true },
                { text: 'De Bernab\u00E9' },

            ]
        },
        {
            text: "\u00BFDe qui\u00E9n era el bidet?",
            responses: [
                { text: 'De Longina' },
                { text: 'De Mam\u00e1 In\u00E9s' },
                { text: 'De Paulina', correct: true },

            ]
        },
        {
            text: "\u00BFDe d\u00f3nde era el Caballero?",
            responses: [
                { text: 'De La Loma' },
                { text: 'De Par\u00eds', correct: true },
                { text: 'Del Perico' },

            ]
        },
        {
            text: "\u00BFA qui\u00E9n tumb\u00f3 la mula?",
            responses: [
                { text: 'A Songo' },
                { text: 'A Genaro', correct: true },
                { text: 'A Bartolo' },

            ]
        },
        {
            text: "\u00BFQu\u00E9 canta la gente cuando se muere?",
            responses: [
                { text: 'El Manisero', correct: true },
                { text: 'A Pap\u00e1 Montero' },
                { text: 'La Chambelona' },

            ]
        },
        {
            text: "\u00BFQu\u00E9 hizo la ni\u00F1a en el tronco de un \u00e1rbol?",
            responses: [
                { text: 'Cantar' },
                { text: 'Escribir', correct: true },                
                { text: 'Llorar' },

            ]
        },
        {
            text: "\u00BFQu\u00E9 es Cuba de las Antillas?",
            responses: [
                { text: 'La llave' },
                { text: 'La rosa' },
                { text: 'La perla', correct: true },

            ]
        },
        {
            text: "\u00BFA qui\u00E9n le di\u00f3 Borondongo?",
            responses: [
                { text: 'A Songo' },
                { text: 'A Muchilanga' },
                { text: 'A Bernab\u00E9', correct: true },

            ]
        },
        {
            text: "\u00BFQu\u00E9 tiene que hacer el que siembra su ma\u00edz?",
            responses: [
                { text: 'Comerse su tamal' },
                { text: 'Comerse su pinol', correct: true },
                { text: 'Hacerse su tamal'  },

            ]
        },
        {
            text: "\u00BFDe qu\u00E9 tiene, el que no tiene de Congo?",
            responses: [
                { text: 'De Karabali', correct: true },
                { text: 'De Yoruba' },
                { text: 'De Babalu' },

            ]
        },
        {
            text: "\u00BFQui\u00E9n camina asi?",
            responses: [
                { text: 'Chencha La Gamb\u00e1'  },
                { text: 'Tula' },
                { text: 'La mujer de Antonio', correct: true },

            ]
        },
        {
            text: "\u00BFQu\u00E9 son Cuba y Puerto Rico?",
            responses: [
                { text: 'Alas de un p\u00e1jaro', correct: true },
                { text: 'Islas similares' },
                { text: 'Pa\u00edses de origen Ta\u00edno' },

            ]
        },
        {
            text: "\u00BFDe d\u00f3nde son los cantantes?",
            responses: [
                { text: 'Santa Isabel de las Lajas' },
                { text: 'La Loma', correct: true },
                { text: 'Varadero' },

            ]
        },
        {
            text: " \u00BFDe qu\u00E9 metal era Maceo el tit\u00e1n?",
            responses: [
                { text: 'Acero' },
                { text: 'Bronce', correct: true },
                { text: 'Hierro' },

            ]
        },
  ] 
};
      
new Vue({
  el: '#tdc',
  data: {
    quiz: quiz,
    questionIndex: 0,
      userResponses: Array(quiz.questions.length).fill(false),
    result: 0,
    start: false,
	balertc: '',
	balertm: ''
  },
  methods: {
    addPciento: function(){ 
        axios.post("<?php echo $ajaxfp ?>", {
            result: this.pciento
        })
        .then(function (response) {
        console.log(response);
    }); },
    // Go to next question
    next: function() {
		if (this.userResponses[this.questionIndex] != false) {
			this.questionIndex++; }
		else
			alert('Debe seleccionar una respuesta');
    },
    score: function() {
        this.result = this.userResponses.filter(function (val) { return val }).length;
        return this.result;
    },
    tdcs: function() {
     return this.start = true;
	},
    tdri() {
     location.reload();
	},
	tdcres: function() {
		var bclass = "alert alert-";
		this.next();
        this.addPciento();
		if (this.pciento > 85) {
			balertc = 'success';
			this.balertm = 'Genial!!'; }
				else if (this.pciento > 60) {
					balertc = 'info';
					this.balertm = 'Muy bien!!'; }
						else {
							balertc = 'warning';
							this.balertm = 'No estas muy ducho en los temas cubanos'; }
        this.balertc = bclass + balertc + ' alert-dismissible fade show';
		}
   },
  computed: {
      pciento() {
          return Math.round((this.result * 100 / this.quiz.questions.length));
      }
    }
});

</script>