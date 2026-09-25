package com.example.v5.service

import android.Manifest
import android.annotation.SuppressLint
import android.app.Service
import android.content.Intent
import android.content.pm.PackageManager
import android.graphics.BitmapFactory
import android.os.IBinder
import androidx.core.app.ActivityCompat
import androidx.core.app.NotificationCompat
import androidx.core.app.NotificationManagerCompat
import com.example.v5.R
import java.util.*


class NotifcService : Service() {

    //Inicia el servicio
    @SuppressLint("SuspiciousIndentation")
    override fun onStartCommand(intent: Intent?, flags: Int, startId: Int): Int {

        //Hora actual segun el calendario
        val now = Calendar.getInstance()
        //Comprobacion con la cual se consigue que la notificacion aparezca cada hora en punto

        if (now.get(Calendar.SECOND) == 0) {
            //por aqui con el intent extras pasar los datos del texto hacer una variable string y que sea el texto
            //Obtencion de los datos del Main
            val temperaturaIntent = intent?.getStringExtra("temperatura")
            val lluviaIntent = intent?.getStringExtra("lluvia")

            //Texto adaptativo al idioma
            val texto1Notificacion : String = getString(R.string.txtNoti1)
            val texto2Notificacion : String = getString(R.string.txtNoti2)


            //Creacion la notificación
            val builder = NotificationCompat.Builder(this, "canal1")
                //Titulo que llevara la notificacion
                .setContentTitle("Proximos datos meteorologicos")
                //Icono que llevara la notificacion sera el mismo que nuestra ApK
                .setSmallIcon(R.drawable.icon_notification)
                .setLargeIcon(BitmapFactory.decodeResource(resources, R.drawable.ic_launcher_foreground))
                .setStyle(NotificationCompat.BigTextStyle()
                    //Texto de la notificación
                    .bigText(texto1Notificacion + temperaturaIntent + texto2Notificacion + lluviaIntent))
                    //Prioridad para que a la hora de lanzar la notificacion pase a primer plano y se ejecute
                .setPriority(NotificationCompat.PRIORITY_HIGH)
                .setAutoCancel(true)

            // Muestra la Notificación para el Servicio
            val notificationManager = NotificationManagerCompat.from(this)
            if (ActivityCompat.checkSelfPermission(
                    this,
                    Manifest.permission.POST_NOTIFICATIONS
                ) != PackageManager.PERMISSION_GRANTED
            )
            //Ejecutar la notificacion
            notificationManager.notify(1, builder.build())
            startForeground(1, builder.build())
        }

        //Consigue que el servicio se ejecute sin parar
        return START_STICKY
    }

    override fun onBind(intent: Intent?): IBinder? {
        return null
    }
}
