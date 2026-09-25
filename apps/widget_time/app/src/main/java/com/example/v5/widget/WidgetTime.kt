package com.example.v5.widget

import android.annotation.SuppressLint
import android.app.PendingIntent
import android.appwidget.AppWidgetManager
import android.appwidget.AppWidgetProvider
import android.content.Context
import android.content.Intent
import android.os.Build
import android.widget.RemoteViews
import android.widget.Toast
import androidx.annotation.RequiresApi
import com.example.v5.R
import com.example.v5.BuildConfig
import org.json.JSONObject
import java.net.URL
import java.time.LocalDateTime
import java.time.format.DateTimeFormatter
import java.util.*
import android.content.res.*
import java.io.ByteArrayInputStream
import java.io.File
import java.io.FileInputStream
import java.security.KeyStore
import java.security.cert.CertificateFactory
import java.security.cert.X509Certificate
import javax.net.ssl.HttpsURLConnection
import javax.net.ssl.SSLContext
import javax.net.ssl.SSLSocketFactory
import javax.net.ssl.TrustManagerFactory


const val MyOnClick : String = "myOnClickTag"

/**
 * Implementation of App Widget functionality.
 * App Widget Configuration implemented in [WidgetTimeConfigureActivity]
 */
class WidgetTime : AppWidgetProvider() {
    @RequiresApi(Build.VERSION_CODES.O)
    override fun onUpdate(
        context: Context,
        appWidgetManager: AppWidgetManager,
        appWidgetIds: IntArray
    ) {
        for (appWidgetId in appWidgetIds) {
            updateAppWidget(context, appWidgetManager, appWidgetId)
        }
    }

    override fun onDeleted(context: Context, appWidgetIds: IntArray) {

        for (appWidgetId in appWidgetIds) {
            deleteTitlePref(context, appWidgetId)
        }
    }

    override fun onEnabled(context: Context) {
    }

    override fun onDisabled(context: Context) {
    }

    //Poder clicar en la imagen y reiniciar el widget
    @RequiresApi(Build.VERSION_CODES.O)
    override fun onReceive(context: Context, intent: Intent?) {
        super.onReceive(context, intent)
        if(MyOnClick == intent?.action){
            val appWidgetId = intent.getIntExtra("appWidget",0)
            updateAppWidget(context, AppWidgetManager.getInstance(context), appWidgetId)
            Toast.makeText(context, "Se ha actualizado con exito", Toast.LENGTH_SHORT).show()
        }
    }
}

//Inicio de la aplicación
@SuppressLint("DiscouragedApi", "SuspiciousIndentation")
@RequiresApi(Build.VERSION_CODES.O)//-------------------------------------------------------------------------------------------------------------------------------
internal fun updateAppWidget(
    context: Context,
    appWidgetManager: AppWidgetManager,
    appWidgetId: Int
) {

    val intent = Intent(context, WidgetTime::class.java)
    intent.action = MyOnClick
    intent.putExtra("appWidget", appWidgetId)
    val pendingIntent = if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.S) {
        PendingIntent.getBroadcast(context, 0, intent, PendingIntent.FLAG_MUTABLE)
    } else {
        TODO("VERSION.SDK_INT < S")
    }
    // Enlazar con los textView desde sin tener ese xml enlazado
    val views = RemoteViews(context.packageName, R.layout.widget_time)
    //Recoger el click en la imagen
    views.setOnClickPendingIntent(R.id.IMGReload, pendingIntent)


    var imgTiempoTxT: String

    val apiWeather1 = URL("https://api.weatherapi.com/v1/forecast.json?key=${BuildConfig.WEATHER_API_KEY}&q=Gij%C3%B3n&days=1&aqi=yes&alerts=no")
        with(apiWeather1.openConnection().getInputStream()) {
        val response = Scanner(this, "UTF-8").useDelimiter("\\A").next()
        val data = JSONObject(response)

        //Cojo la hora actual y para que el formato sea igual que el pattern de la hora de la Api, los segundos los añado a posteriori para que siempre sean "00"
        val dateTimeHORA = LocalDateTime.now()
            .format(DateTimeFormatter.ofPattern("yyyy-MM-dd HH"))
        val fechaCOmpleta: String = dateTimeHORA + ":00"

        //datosHoras contiene los datos por hora del array, luego hay que recorrer dicho array
        val datosHoras = data.getJSONObject("forecast").getJSONArray("forecastday").getJSONObject(0)
            .getJSONArray("hour")
        for (i in 0 until datosHoras.length()) {
            val timePattern: String = datosHoras.getJSONObject(i).getString("time")
//----------------------------------------------------------------------------------------------------------------------------------------------------SOLO FUNCIONA DESDE ESPAÑA -01:00 ERORR EN CANARIAS
            //Comparo las fechas con el mismo formato con el fin que si se cumple la condición mueste los datos exactos de la hora actual
            if (fechaCOmpleta == timePattern) {
                //Muestro los datos por pantalla
                views.setTextViewText(
                    R.id.WIDGTMP1,
                    datosHoras.getJSONObject(i).getDouble("temp_c").toString() + "°C"
                )
            }
        }

        //Aqui muestro las temperaturas maximas y minimas del dia
        val datosHoras2 =
            data.getJSONObject("forecast").getJSONArray("forecastday").getJSONObject(0)
                .getJSONObject("day")
        views.setTextViewText(
            R.id.WIDGTMP1MAX,
            datosHoras2.getDouble("maxtemp_c").toString() + "°C"
        )
        views.setTextViewText(
            R.id.WIDGTMP1MIN,
            datosHoras2.getDouble("mintemp_c").toString() + "°C"
        )
        imgTiempoTxT = datosHoras2.getJSONObject("condition").getString("icon")
    }


    //-------------------------------------Datos de la tercera API del tiempo-------------------------------------
    //Pasar los datos al Recycled View para que se muestren
    val datosTiempoV1: Array<Array<String>> = Array(24) {
        Array(4) {
            "data22"
        }
    }
    //Creo la variable para recoger el dato, recogido en el idioma del dispositivo movil
    val dia = context.getString(R.string.dia)

    //Parte del widget que indica la media de temperaturas de los venideros dias
    val apiWeather3 = URL("https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/Gij%C3%B3n?unitGroup=metric&key=${BuildConfig.VISUAL_CROSSING_API_KEY}&contentType=json")
        val connection = apiWeather3.openConnection() as HttpsURLConnection
        connection.sslSocketFactory = getSSLSocketFactory3(context)
        with(connection.inputStream) {
            val response = Scanner(this, "UTF-8").useDelimiter("\\A").next()
            val data = JSONObject(response)

        //datosHoras contiene los datos por hora del array, luego hay que recorrer dicho array
        val datosHoras = data.getJSONArray("days")

        for (j in 0 until datosHoras.length()) {
            //Aqui muestro las temperaturas maximas y minimas de los proximos dias de la semana
            datosTiempoV1[j][0] =
                dia + datosHoras.getJSONObject(j).getString("datetime").toString().substring(8, 10)
            datosTiempoV1[j][1] =
                "   " + datosHoras.getJSONObject(j).getDouble("tempmax").toString() + "°C"
            datosTiempoV1[j][2] = datosHoras.getJSONObject(j).getDouble("tempmin").toString() + "°C"
            datosTiempoV1[j][3] = datosHoras.getJSONObject(j).getDouble("precipprob")
                .toString() + "%"
        }

        //Se realiza este código con el fin de evitar obtener "data22" en cada posicion del array
        if (datosTiempoV1[0][1] != "data22") {
            views.setTextViewText(R.id.NonRLY1, datosTiempoV1[0][0])
            views.setTextViewText(R.id.NonRLY2, datosTiempoV1[0][1] + " / " + datosTiempoV1[0][2])
            views.setTextViewText(R.id.NonRLY3, datosTiempoV1[0][3])
        } else {
            views.setTextViewText(R.id.NonRLY1, "")
            views.setTextViewText(R.id.NonRLY2, "")
            views.setTextViewText(R.id.NonRLY3, "")
        }

        if (datosTiempoV1[1][1] != "data22") {
            views.setTextViewText(R.id.NonRLY4, datosTiempoV1[1][0])
            views.setTextViewText(R.id.NonRLY5, datosTiempoV1[1][1] + " / " + datosTiempoV1[1][2])
            views.setTextViewText(R.id.NonRLY6, datosTiempoV1[1][3])
        } else {
            views.setTextViewText(R.id.NonRLY4, "")
            views.setTextViewText(R.id.NonRLY5, "")
            views.setTextViewText(R.id.NonRLY6, "")
        }

        if (datosTiempoV1[2][1] != "data22") {
            views.setTextViewText(R.id.NonRLY7, datosTiempoV1[2][0])
            views.setTextViewText(R.id.NonRLY8, datosTiempoV1[2][1] + " / " + datosTiempoV1[2][2])
            views.setTextViewText(R.id.NonRLY9, datosTiempoV1[2][3])
        } else {
            views.setTextViewText(R.id.NonRLY7, "")
            views.setTextViewText(R.id.NonRLY8, "")
            views.setTextViewText(R.id.NonRLY9, "")
        }
        if (datosTiempoV1[3][1] != "data22") {
            views.setTextViewText(R.id.NonRLY10, datosTiempoV1[3][0])
            views.setTextViewText(R.id.NonRLY11, datosTiempoV1[3][1] + " / " + datosTiempoV1[3][2])
            views.setTextViewText(R.id.NonRLY12, datosTiempoV1[3][3])
        } else {
            views.setTextViewText(R.id.NonRLY10, "")
            views.setTextViewText(R.id.NonRLY11, "")
            views.setTextViewText(R.id.NonRLY12, "")
        }
        if (datosTiempoV1[4][1] != "data22") {
            views.setTextViewText(R.id.NonRLY13, datosTiempoV1[4][0])
            views.setTextViewText(R.id.NonRLY14, datosTiempoV1[4][1] + " / " + datosTiempoV1[4][2])
            views.setTextViewText(R.id.NonRLY15, datosTiempoV1[4][3])
        } else {
            views.setTextViewText(R.id.NonRLY13, "")
            views.setTextViewText(R.id.NonRLY14, "")
            views.setTextViewText(R.id.NonRLY15, "")
        }
        if (datosTiempoV1[5][1] != "data22") {
            views.setTextViewText(R.id.NonRLY16, datosTiempoV1[5][0])
            views.setTextViewText(R.id.NonRLY17, datosTiempoV1[5][1] + " / " + datosTiempoV1[5][2])
            views.setTextViewText(R.id.NonRLY18, datosTiempoV1[5][3])
        } else {
            views.setTextViewText(R.id.NonRLY16, "")
            views.setTextViewText(R.id.NonRLY17, "")
            views.setTextViewText(R.id.NonRLY18, "")
        }
    }


    //-------------------------------------Mostrar la imagen del clima actual-------------------------------------
    //Almaceno el nombre de la imagen que recogere de la carpeta de imagnes de la aplicación para luego mostararla
    var imgName: String = imgTiempoTxT.substring(39, imgTiempoTxT.length - 4)
    //Como no se pueden crear carpetas dentro de "drawable", procedo a añadir cambiandoles el nombre y estas se diferencian porque contiene un 9 antes de su numero de archivo
    if(imgTiempoTxT.substring(33, imgTiempoTxT.length - 8)=="night"){
        //Para evitar el problema con los 5 caracteres de la palabara night a la hora de recoger los datos
        imgName = imgTiempoTxT.substring(41, imgTiempoTxT.length - 4)
        //Las fotos de noche y de dia tienen el mismo nombre por lo que añado un 9 para distinguirlas
        imgName = "9"+imgName
    }
    //El nombre de la imagen no puede empezar por un caracter numerico por lo que añadiré un "_"
    imgName = "tiempo_"+imgName
    //Consigo el id de la imagen para luego pasarselo a la aplicación y esta lo interprete y acabe mostrando la imagen
    val idImagenDrawable: Int = context.resources.getIdentifier(imgName, "drawable", context.packageName)
     views.setImageViewResource(R.id.WIDGTMP1IMG, idImagenDrawable)


    appWidgetManager.updateAppWidget(appWidgetId, views)




}

//Funcion en la cual introduzco credenciales para poder para que los datos pueda ser recogidos con seguridad de la API3
private fun getSSLSocketFactory3(context: Context): SSLSocketFactory {
    //Lee el certificado descargado e importado al proyecto
    val certStream = context.resources.openRawResource(R.raw.visualcrossing)

    //Comprueba que el certificado se carga en el buffer correctamente
    val certBytes = certStream.readBytes()
    val certFile = File(context.filesDir, "visualcrossing.crt")
    certFile.writeBytes(certBytes)

    val fileInputStream = FileInputStream(File(context.filesDir, "visualcrossing.crt"))
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

    val url = URL("https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/Gij%C3%B3n?unitGroup=metric&key=${BuildConfig.VISUAL_CROSSING_API_KEY}&contentType=json")
    val httpsURLConnection = url.openConnection() as HttpsURLConnection
    httpsURLConnection.sslSocketFactory = sslContext.socketFactory


    return sslContext.socketFactory
}
