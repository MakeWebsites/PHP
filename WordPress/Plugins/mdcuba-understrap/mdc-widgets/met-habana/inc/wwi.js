Vue.component('wwi', {
    props: {
        wep: String
    },
    data() {
        return {
            wi: ''
             }
    },
    created() {
        var wi = '';
        switch (this.wep) {
            case 'Sandstorm': case 'Duststorm': case 'Sand': case 'Dust': wi = "wind"; break;
            case 'Thundershowers': case 'Storm':  wi ="cloud-showers-heavy"; break;
            case 'Thunderstorms': case 'Lightning': wi ="poo-storm"; break;
            case 'Cool': case 'Cold': case 'Chilly': case 'Blowing Snow': case 'Blizzard': case 'Snowdrift': case 'Snowstorm': case 'Hail': case 'Freezing': case 'Frost':   wi = "snowflake"; break;
            case 'Snow Showers': case 'Flurries': case 'Snow': case 'Heavy Snow': case 'Snowfall': case 'Light Snow':  wi = "snowflake"; break;
            case 'Sleet': case 'Showers': case 'Scattered Showers': case 'Heavy Showers': case 'Rainshower': wi="cloud-showers-heavy"; break;
            case 'Occasional Showers': case 'Isolated Showers': case 'Light Showers': case 'Freezing Rain': case 'Rain': case 'Drizzle': case 'Light Rain': wi="cloud-rain"; break;
            case 'Fog': case 'Mist': case 'Smoke': case 'Haze': case 'Overcast': wi="fas smog"; break; 
            case 'Sunny Intervals': case 'No Rain': case 'Clearing': case 'Sunny Periods': case 'Partly Cloudy': case 'Partly Bright': case 'Mild': wi="cloud-sun"; break;
            case 'Cloudy': case 'Mostly Cloudy':  wi="cloud"; break;
            case 'Warm': case 'Hot': case 'Bright': case 'Sunny': case 'Fair': case 'Fine': case 'Clear': case 'Dry': wi="sun"; break;
            case 'Windy': case 'Squall': case 'Stormy': case 'Gale': wi = "wind"; break;
            case 'Wet': case 'Humid': wi="umbrella"; break;              
            case 'Volcanic Ash': wi="blot"; break;
        }
        this.wi = wi;
    },
    template: `
    <i :class="'fas fa-' + wi"></i>
    `
})
