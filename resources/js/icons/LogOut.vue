<template>
    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
         :width="width" :height="height" viewBox="0 0 512.000000 512.000000"
         preserveAspectRatio="xMidYMid meet"
         :class="'bkt-fill-'+color"
    >
        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)">
            <path d="M161 5103 c-59 -21 -124 -87 -144 -148 -16 -45 -17 -237 -17 -2395 0
                                            -2633 -7 -2404 75 -2485 80 -80 -21 -75 1430 -75 1451 0 1350 -5 1430 75 98
                                            98 98 252 0 350 -79 80 4 75 -1287 75 l-1148 0 0 2060 0 2060 1148 0 c1291 0
                                            1208 -5 1287 75 98 98 98 252 0 350 -80 80 22 75 -1434 74 -1147 0 -1301 -2
                                            -1340 -16z"/>
            <path d="M3520 4065 c-136 -44 -208 -205 -149 -335 15 -34 127 -152 457 -482
                                            l437 -438 -1216 0 c-1366 0 -1274 5 -1354 -75 -98 -98 -98 -252 0 -350 80 -80
                                            -12 -75 1354 -75 l1216 0 -437 -437 c-240 -241 -444 -454 -454 -473 -27 -51
                                            -25 -162 3 -216 25 -47 82 -101 129 -120 48 -20 151 -17 200 5 61 28 1354
                                            1315 1386 1379 32 65 32 159 0 224 -30 60 -1320 1347 -1384 1379 -52 27 -131
                                            33 -188 14z"/>
        </g>
    </svg>
</template>

<script>
    export default {
        name: "LogOut",
        props: {
            color:{
                type:String,
                default:'red'
            },
            width:{
                type:String,
                default:'100%'
            },
            height:{
                type:String,
                default:'100%'
            },
        }
    }
</script>

<style scoped>

</style>
