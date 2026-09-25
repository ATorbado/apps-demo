package com.example.v5

import android.Manifest
import android.annotation.SuppressLint
import android.app.NotificationChannel
import android.app.NotificationManager
import android.content.Context
import android.content.Intent
import android.content.pm.PackageManager
import android.icu.lang.UCharacter.toLowerCase
import android.os.*
import android.os.StrictMode.ThreadPolicy
import android.widget.ImageView
import android.widget.RelativeLayout
import android.widget.TextView
import android.widget.Toast
import androidx.activity.result.contract.ActivityResultContracts
import androidx.annotation.RequiresApi
import androidx.appcompat.app.AppCompatActivity
import androidx.core.app.ActivityCompat
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout
import com.example.v5.adaptador.VistaScrollRVAdap
import com.example.v5.service.NotifcService
import com.squareup.picasso.Picasso
import kotlinx.coroutines.flow.internal.*
import org.json.JSONObject
import java.net.URL
import java.time.LocalDateTime
import java.time.format.DateTimeFormatter
import java.util.*
import javax.net.ssl.HttpsURLConnection


import java.io.ByteArrayInputStream
import java.io.File
import java.io.FileInputStream

import java.security.KeyStore
import java.security.cert.CertificateFactory
import java.security.cert.X509Certificate

import javax.net.ssl.SSLContext
import javax.net.ssl.SSLSocketFactory
import javax.net.ssl.TrustManagerFactory



class MainActivity : AppCompatActivity() {
    @SuppressLint("ResourceAsColor")
    @RequiresApi(Build.VERSION_CODES.O)

    //Variables globales con las que obtengo la temperatura y las precipitaciones
    var tempertaturaServvice: String ="22ºC"
    var lluviaServvice: String ="38%"

    @RequiresApi(Build.VERSION_CODES.O)
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        //-------------------------------------Recargar la pagina deslizando hacia abajo-------------------------------------
        val swipeLayout = findViewById<SwipeRefreshLayout>(R.id.Desliz)
        swipeLayout.setOnRefreshListener {
            onStop()
            onStart()
            onRestart()
            datosApi1()
            datosApi2()
            notificactionPOPdown()
            Handler(Looper.getMainLooper()).postDelayed({
                swipeLayout.isRefreshing = false
                Toast.makeText(this, "Actualizado con exito", Toast.LENGTH_SHORT).show()
            }, 2000)
        }





        //-------------------------------------Chequeo de permisos y su activación-------------------------------------
        if (ActivityCompat.checkSelfPermission(
                this,
                Manifest.permission.INTERNET
            ) != PackageManager.PERMISSION_GRANTED
        ) {
            ActivityCompat.requestPermissions(
                this@MainActivity,
                arrayOf(Manifest.permission.INTERNET),
                1
            )
        }
        if (ActivityCompat.checkSelfPermission(
                this,
                Manifest.permission.POST_NOTIFICATIONS
            ) != PackageManager.PERMISSION_GRANTED
        ) {
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.TIRAMISU) {
                ActivityCompat.requestPermissions(
                    this@MainActivity,
                    arrayOf(Manifest.permission.POST_NOTIFICATIONS),
                    1
                )
            }
        }
        if (ActivityCompat.checkSelfPermission(
                this,
                Manifest.permission.FOREGROUND_SERVICE
            ) != PackageManager.PERMISSION_GRANTED
        ) {
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.P) {
                ActivityCompat.requestPermissions(
                    this@MainActivity,
                    arrayOf(Manifest.permission.FOREGROUND_SERVICE),
                    1
                )
            }
        }


        registerForActivityResult(
            ActivityResultContracts.RequestPermission()
        ) { isGranted ->

            if (isGranted)
                Toast.makeText(this, "Granted", Toast.LENGTH_SHORT).show()
            else
                Toast.makeText(this, "Denied", Toast.LENGTH_SHORT).show()
            finish()
        }
        val policy = ThreadPolicy.Builder().permitAll().build()
        StrictMode.setThreadPolicy(policy)


        datosApi1()
        datosApi2()
        notificactionPOPdown()

    }

    //-------------------------------------Ejecucion de la notificacion-------------------------------------
    @RequiresApi(Build.VERSION_CODES.O)
    fun notificactionPOPdown(){
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
                // Crea el canal de notificación
                val name = "canal1"
                val descriptionText = "Descripción del canal"
                val importance = NotificationManager.IMPORTANCE_HIGH
                val channel = NotificationChannel("canal1", name, importance).apply {
                    description = descriptionText
                }

                // Registra el canal con el NotificationManager
                val notificationManager: NotificationManager =
                    getSystemService(Context.NOTIFICATION_SERVICE) as NotificationManager
                notificationManager.createNotificationChannel(channel)
            }


            val notifc2 = Intent(this, NotifcService::class.java)
            //Los valores que se van a pasar desde el main hasta el service para el texto de la notificación
            notifc2.putExtra("temperatura", tempertaturaServvice)
            notifc2.putExtra("lluvia", lluviaServvice)

            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
                //ContextCompat.startForegroundService(this, notifc2)
            } else {
                startService(notifc2)
            }
        }



        //-------------------------------------Estos datos se recogen de la Api del tiempo conocida como weatherapi-------------------------------------
        @SuppressLint("SetTextI18n", "UseCompatLoadingForDrawables")
        @RequiresApi(Build.VERSION_CODES.O)
        fun datosApi1(){
            //Declaro las principales variables que usare luego
            val idDCiudad = findViewById<TextView>(R.id.IDCiudad)
            val idDTemperatura = findViewById<TextView>(R.id.IDTemperatura)
            val idDCielo = findViewById<TextView>(R.id.IDCielo)
            val idDImagenTMP = findViewById<ImageView>(R.id.IDImagenTMP)
            val recyclerView = findViewById<RecyclerView>(R.id.IDLateralDatos)
            val fondoLY = findViewById<RelativeLayout>(R.id.idRLMain)

            val datosTiempoV1 : Array<Array<String>> =  Array(24) {
                Array(10) {
                    "dato9"
                }
            }

            var checkDatosMostrados = 0
            var j = 0
            var idImagenDrawable = 0
            //Creo la variable para recoger el dato, recogido en el idioma del dispositivo movil
            val humedad = getString(R.string.humedad)
            val ciudad = getString(R.string.IDCiudad)
            val lluviachance = getString(R.string.lluvia)

            //-------------------------------------Proceso de recogida de datos de la API-------------------------------------
            val apiWeather1 = URL("https://api.weatherapi.com/v1/forecast.json?key=${BuildConfig.WEATHER_API_KEY}&q=Gij%C3%B3n&days=1&aqi=yes&alerts=no")
            val connection = apiWeather1.openConnection() as HttpsURLConnection
            connection.sslSocketFactory = getSSLSocketFactory2(this)
            with(connection.inputStream) {
                val response = Scanner(this, "UTF-8").useDelimiter("\\A").next()
                val data = JSONObject(response)
                //Cojo la hora actual y para que el formato sea igual que el pattern de la hora de la Api, los segundos los añado a posteriori para que siempre sean "00"
                val dateTimeHORA = LocalDateTime.now()
                    .format(DateTimeFormatter.ofPattern("yyyy-MM-dd HH"))
                val fechaCOmpleta : String = dateTimeHORA+":00"

                //datosHoras contiene los datos por hora del array, luego hay que recorrer dicho array
                val datosHoras = data.getJSONObject("forecast").getJSONArray("forecastday").getJSONObject(0).getJSONArray("hour")
                for (i in 0 until datosHoras.length()) {
                    //Con este if consigo que a la hora de mostrar los datos, solo se muestren solo las horas posteriores no las ya pasadas
                    if(j!=i){
                        //Sirve para que no se  muestre la misma hora en la pantalla principal como en el Recycled View
                        j=i-1
                    }

                    val timePattern: String = datosHoras.getJSONObject(i).getString("time")
//----------------------------------------------------------------------------------------------------------------------------------------------------SOLO FUNCIONA DESDE ESPAÑA -01:00 ERORR EN CANARIAS
                        //Comparo las fechas con el mismo formato con el fin que si se cumple la condición mueste los datos exactos de la hora actual
                    if (fechaCOmpleta == timePattern) {
                        //Muestro los datos por pantalla
                        idDTemperatura.text = datosHoras.getJSONObject(i).getDouble("temp_c").toString()+"°C"
                        idDCiudad.text = ciudad + data.getJSONObject("location").getString("name")
                        idDCielo.text = datosHoras.getJSONObject(i).getJSONObject("condition").getString("text")
                        val stringFotoBien: String = datosHoras.getJSONObject(i).getJSONObject("condition").getString("icon")

                        //-------------------------------------Mostrar imagenes del clima actual-------------------------------------
                        //Almaceno el nombre de la imagen que recogere de la carpeta de imagnes de la aplicación para luego mostararla
                        var imgName: String = stringFotoBien.substring(39, stringFotoBien.length - 4)
                        //Como no se pueden crear carpetas dentro de "drawable", procedo a añadir cambiandoles el nombre y estas se diferencian porque contiene un 9 antes de su numero de archivo
                        if(stringFotoBien.substring(35, stringFotoBien.length - 8)=="night"){
                            //Para evitar el problema con los 5 caracteres de la palabara night a la hora de recoger los datos
                            imgName = stringFotoBien.substring(41, stringFotoBien.length - 4)
                            //Las fotos de noche y de dia tienen el mismo nombre por lo que añado un 9 para distinguirlas
                            imgName = "9"+imgName
                        }
                        //El nombre de la imagen no puede empezar por un caracter numerico por lo que añadiré un "_"
                        imgName = "tiempo_"+imgName
                        //Consigo el id de la imagen para luego pasarselo a la aplicación y esta lo interprete y acabe mostrando la imagen
                        idImagenDrawable = resources.getIdentifier(imgName, "drawable", packageName)
                        Picasso.get().load(idImagenDrawable).into(idDImagenTMP)

                        //Datos recogidos para mostar en la notificacion
                        tempertaturaServvice = datosHoras.getJSONObject(i).getDouble("temp_c").toString()+"°C"
                        lluviaServvice = datosHoras.getJSONObject(i).getInt("chance_of_rain").toString()+"%"

                        //El unico uso de este "checking" es comprobrar que estos datos son correctamente recogidos y mostrados por pantalla
                        checkDatosMostrados = 33

                        //Segun el la condición climatiuca en la que se encuentre Gijón, se establecerá un fondo de pantalla u otro
                        val timpoTiempo : String = toLowerCase(datosHoras.getJSONObject(i).getJSONObject("condition").getString("text"))
                        if (timpoTiempo.contains("cloudy")){
                            fondoLY.background = getDrawable(R.drawable.nublado)
                        }else if (timpoTiempo.contains("rain")){
                            fondoLY.background = getDrawable(R.drawable.lluvia)
                        }else if (timpoTiempo.contains("overcast")){
                            fondoLY.background = getDrawable(R.drawable.nublado)
                        }else if (timpoTiempo.contains("sunny")){
                            fondoLY.background = getDrawable(R.drawable.soleado)
                        }else if (timpoTiempo.contains("snow")){
                            fondoLY.background = getDrawable(R.drawable.nevado)
                        }else{
                            fondoLY.background = getDrawable(R.drawable.resource_else)//MEJOR CALIDAD
                        }

                        println(idImagenDrawable)
                    }
                        println(idImagenDrawable)
                    //-------------------------------------Pasar los datos al Recycled View para que se muestren-------------------------------------
                    if(timePattern.substring(11,13).toInt()>dateTimeHORA.substring(11,13).toInt()) {
                        //Por cada parte del array, almaceno datos para luego pasar direcctamente el array y poder mostrarlos
                        datosTiempoV1[j][0] = timePattern.substring(11, timePattern.length) + "h"
                        datosTiempoV1[j][1] = datosHoras.getJSONObject(i).getDouble("temp_c")
                            .toString() + "°C"
                        datosTiempoV1[j][2] =
                            datosHoras.getJSONObject(i).getJSONObject("condition")
                                .getString("text")
                        datosTiempoV1[j][3] = idImagenDrawable.toString()
                        datosTiempoV1[j][4] = datosHoras.getJSONObject(i).getInt("chance_of_rain")
                            .toString() + lluviachance
                        datosTiempoV1[j][5] = datosHoras.getJSONObject(i).getInt("humidity")
                            .toString() + humedad
                        datosTiempoV1[j][6] = datosHoras.getJSONObject(i).getDouble("uv")
                            .toString() + " uv"
                        datosTiempoV1[j][7] = datosHoras.getJSONObject(i).getDouble("wind_kph")
                            .toString() + "km/h"
                        datosTiempoV1[j][8] =
                            datosHoras.getJSONObject(i).getString("wind_dir").toString()


                        var gradosPosicionViento = 90.87
                        when (datosTiempoV1[j][8]) {
                            "N" -> {
                                gradosPosicionViento = 0.0
                            }
                            "NNE" -> {
                                gradosPosicionViento = 22.5
                            }
                            "NE" -> {
                                gradosPosicionViento = 45.0
                            }
                            "ENE" -> {
                                gradosPosicionViento = 67.5
                            }
                            "E" -> {
                                gradosPosicionViento = 90.0
                            }
                            "ESE" -> {
                                gradosPosicionViento = 112.5
                            }
                            "SE" -> {
                                gradosPosicionViento = 135.0
                            }
                            "SSE" -> {
                                gradosPosicionViento = 157.5
                            }
                            "S" -> {
                                gradosPosicionViento = 180.0
                            }
                            "SSO" -> {
                                gradosPosicionViento = 202.5
                            }
                            "SO" -> {
                                gradosPosicionViento = 225.0
                            }
                            "OSO" -> {
                                gradosPosicionViento = 247.5
                            }
                            "O" -> {
                                gradosPosicionViento = 270.0
                            }
                            "ONO" -> {
                                gradosPosicionViento = 192.5
                            }
                            "NO" -> {
                                gradosPosicionViento = 315.0
                            }
                            "NNO" -> {
                                gradosPosicionViento = 337.5
                            }
                        }
                        datosTiempoV1[j][9] = gradosPosicionViento.toString() + "º"
                    }
                }
            }



            //-------------------------------------Borro las partes del array que no contienen datos-------------------------------------
            //Los bloques que no tienen datos, se rellenan con "dato9"
            var datoArrayNotNullL =0
            for (w in 0 until datosTiempoV1.size) {
                if(datosTiempoV1[w][0] != "dato9"){
                    datoArrayNotNullL+=1
                }
            }
            //Se filtra consiguiendo solo pasar los bloques del array que contengan información distinta a "dato9"
            val array2DatosTiempoV1 : Array<Array<String>> =  Array(datoArrayNotNullL) {Array(10) {"dato7"}}
            datoArrayNotNullL=0
            for (w in 0 until datosTiempoV1.size) {
                if(datosTiempoV1[w][0] != "dato9"){
                    array2DatosTiempoV1[datoArrayNotNullL]=datosTiempoV1[w]
                    datoArrayNotNullL+=1
                }
            }

            //Poner horizontal
            val horizontalLayoutManagaer = LinearLayoutManager(this@MainActivity, LinearLayoutManager.HORIZONTAL, false)
            recyclerView.layoutManager = horizontalLayoutManagaer
            recyclerView.adapter = VistaScrollRVAdap(array2DatosTiempoV1)

            //Si el "checking" no es correcto, le avisará al usuario que hay algunos problemas
            if (checkDatosMostrados!=33){
                Toast.makeText(this@MainActivity, "La fecha de su dispositivo movil es erronea", Toast.LENGTH_SHORT).show()
            }
        }


        //-------------------------------------Estos datos se recogen de la Api del gobierno sobre los datos meteorologicos-------------------------------------
    @RequiresApi(Build.VERSION_CODES.O)
        fun datosApi2(){

            val idDpm10 = findViewById<TextView>(R.id.IDpm10TXT)
            val idDo3 = findViewById<TextView>(R.id.IDo3TXT)
            val idDso2 = findViewById<TextView>(R.id.IDso2TXT)

            //Este array equivale a la cantidad de dias transcurridos en un año no bisiesto
            val fechas : IntArray = intArrayOf(31,59,90,12,151,181,212,243,273,304,334,365)

            val totalDias: Int
            val numeroArrayPorHoras: Int
            val dateTimeFecha = LocalDateTime.now().format(DateTimeFormatter.ofPattern("MM-dd HH"))//02-15
            val tiempoMeses: Int = dateTimeFecha.substring(0,2).toInt()
            val tiempoDias: Int = dateTimeFecha.substring(3,5).toInt()

            //Al empezar el array por 0 se le resta 1 y el otro es debido a el mes no se recuetne a mayores, es decir,
            //Si la fehca es 16-1 , no quiero que se cuenten los 31 días del mes de enero que no han pasado solo los 16
            if(tiempoMeses-2==-1){
                totalDias = tiempoDias
            }else{
                totalDias = fechas[tiempoMeses-2] + tiempoDias //Se suman los dias a los dias de los meses pasados
            }

            //El numero total de registros de la api es de "50688", y se resta debido a que el ultimo registro es el 1-1 a la hora "01:00"
            val casiNumeroArray: Int = 43800-((totalDias-1)*24)//Le resto 24 horas porque el "perido empieza en 1 y no en 24"

        //////// P$456    50664 antes, esta api va ampopliando y modifciando el numero de elementos que posee, no se obtiene el numero de datos totales poruqe aunque se haga, se descuadra completamente el resultaod a la hroa de calcular fechas dias y la hora exacta

            numeroArrayPorHoras = casiNumeroArray - dateTimeFecha.substring(6,8).toInt()//Se restan las horas para cuadrar con la fehca y hora exacta de los datos que queremos obtener

            //-------------------------------------Proceso de recogida de datos de la API2-------------------------------------
            val apiWeather2 = URL("https://opendata.gijon.es/descargar.php?id=944&tipo=JSON")
            val connection = apiWeather2.openConnection() as HttpsURLConnection
            connection.sslSocketFactory = getSSLSocketFactory(this)
            with(connection.inputStream) {
                val response = Scanner(this, "UTF-8").useDelimiter("\\A").next()
                val data = JSONObject(response)

                    //SON más de 50.000 registros el tiempo de carga de la aplicación es muy alto
                    val pm10 = data.getJSONObject("calidadaires").getJSONArray("calidadaire").getJSONObject(numeroArrayPorHoras).getInt("pm10").toString()
                    val o3 = data.getJSONObject("calidadaires").getJSONArray("calidadaire").getJSONObject(numeroArrayPorHoras).getInt("o3").toString()
                    val so2 = data.getJSONObject("calidadaires").getJSONArray("calidadaire").getJSONObject(numeroArrayPorHoras).getInt("so2").toString()

                    //Se muestran los datos por pantalla
                    // P$456   idDpm10.text = pm10
                    // P$456   idDo3.text = o3
                    // P$456   idDso2.text = so2
                }
            }

    //Funcion en la cual introduzco credenciales para poder para que los datos pueda ser recogidos con seguridad de la API2
    private fun getSSLSocketFactory(context: Context): SSLSocketFactory {
        //Lee el certificado descargado e importado al proyecto
        val certStream = context.resources.openRawResource(R.raw.gijon)

        //Comprueba que el certificado se carga en el buffer correctamente
        val certBytes = certStream.readBytes()
        val certFile = File(context.filesDir, "gijon.crt")
        certFile.writeBytes(certBytes)

        val fileInputStream = FileInputStream(File(context.filesDir, "gijon.crt"))
        val buffer = ByteArray(fileInputStream.available())
        fileInputStream.read(buffer)

        if (!certBytes.contentEquals(buffer)) {
            throw Exception("El contenido del certificado no coincide con el del archivo")
        }

        //Configuramos para usar el certificado X.509 para verificar la identidad a la hora de la conexion
        val certificateFactory = CertificateFactory.getInstance("X.509")
        val cert = certificateFactory.generateCertificate(ByteArrayInputStream(buffer)) as X509Certificate

        //Añado el certificado de confianza
        val tipoCertificadoConexionSegura = TrustManagerFactory.getInstance(TrustManagerFactory.getDefaultAlgorithm())
        val clave = KeyStore.getInstance(KeyStore.getDefaultType())
        clave.load(null)
        clave.setCertificateEntry("ca", cert)

        //Inicio el certificado de seguridad
        tipoCertificadoConexionSegura.init(clave)
        val trustManagers = tipoCertificadoConexionSegura.trustManagers

        val sslContext = SSLContext.getInstance("TLS")
        sslContext.init(null, trustManagers, null)

        val url = URL("https://opendata.gijon.es/descargar.php?id=944&tipo=JSON")
        val httpsURLConnection = url.openConnection() as HttpsURLConnection
        httpsURLConnection.sslSocketFactory = sslContext.socketFactory


        return sslContext.socketFactory
    }


    //Funcion en la cual introduzco credenciales para poder para que los datos pueda ser recogidos con seguridad de la API2
    private fun getSSLSocketFactory2(context: Context): SSLSocketFactory {
        //Lee el certificado descargado e importado al proyecto
        val certStream = context.resources.openRawResource(R.raw.apiweather)

        //Comprueba que el certificado se carga en el buffer correctamente
        val certBytes = certStream.readBytes()
        val certFile = File(context.filesDir, "apiweather.crt")
        certFile.writeBytes(certBytes)

        val fileInputStream = FileInputStream(File(context.filesDir, "apiweather.crt"))
        val buffer = ByteArray(fileInputStream.available())
        fileInputStream.read(buffer)

        if (!certBytes.contentEquals(buffer)) {
            throw Exception("El contenido del certificado no coincide con el del archivo")
        }

        //Configuramos para usar el certificado X.509 para verificar la identidad a la hora de la conexion
        val certificateFactory = CertificateFactory.getInstance("X.509")
        val cert = certificateFactory.generateCertificate(ByteArrayInputStream(buffer)) as X509Certificate

        //Añado el certificado de confianza
        val tipoCertificadoConexionSegura = TrustManagerFactory.getInstance(TrustManagerFactory.getDefaultAlgorithm())
        val clave = KeyStore.getInstance(KeyStore.getDefaultType())
        clave.load(null)
        clave.setCertificateEntry("ca", cert)

        //Inicio el certificado de seguridad
        tipoCertificadoConexionSegura.init(clave)
        val trustManagers = tipoCertificadoConexionSegura.trustManagers

        val sslContext = SSLContext.getInstance("TLS")
        sslContext.init(null, trustManagers, null)

        val url = URL("https://api.weatherapi.com/v1/forecast.json?key=${BuildConfig.WEATHER_API_KEY}&q=Gij%C3%B3n&days=1&aqi=yes&alerts=no")
        val httpsURLConnection = url.openConnection() as HttpsURLConnection
        httpsURLConnection.sslSocketFactory = sslContext.socketFactory


        return sslContext.socketFactory
    }

}
