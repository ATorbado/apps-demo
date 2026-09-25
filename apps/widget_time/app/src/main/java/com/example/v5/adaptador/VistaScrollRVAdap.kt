package com.example.v5.adaptador

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.v5.R
import com.squareup.picasso.Picasso


class VistaScrollRVAdap(val users: Array<Array<String>>): RecyclerView.Adapter<VistaScrollRVAdap.ViewHolder>() {

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view: View = LayoutInflater.from(parent.context).inflate(R.layout.vista_scroll_rv, parent,false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder (holder: ViewHolder, position: Int) {
        //Mostar los datos recuperados del array por pantalla
        holder.idIDhora.text = users[position][0]//.hora
        holder.idIDtempC.text = users[position][1]//.temp_c
        holder.idIDconditionText.text = users[position][2]//.condition_text
        Picasso.get().load(users[position][3].toInt()).into(holder.idIDconditionIcon)
        holder.idIDlluvia.text = users[position][4]//.chance_of_rain
        holder.idIDhumidity.text = users[position][5]//.humidity
        holder.idIDuv.text = users[position][6]//.uv
        holder.idIDwindKph.text = users[position][7]//.wind_kph
        holder.idIDwindDir.text = users[position][8]//.wind_dir
        holder.idIDwindDirGrades.text = users[position][9]//.wind_dirGrades

        //.wind_dirIMGCompas
        when (users[position][8]) {
            //Linkear las imagenes dependiendo de la posición del viento
            "N" -> holder.idIDwindDirIMG.setImageResource(R.drawable.n)
            "NNE" -> holder.idIDwindDirIMG.setImageResource(R.drawable.ne)
            "NE" -> holder.idIDwindDirIMG.setImageResource(R.drawable.ne)
            "ENE" -> holder.idIDwindDirIMG.setImageResource(R.drawable.ne)
            "E" -> holder.idIDwindDirIMG.setImageResource(R.drawable.e)
            "ESE" -> holder.idIDwindDirIMG.setImageResource(R.drawable.se)
            "SE" -> holder.idIDwindDirIMG.setImageResource(R.drawable.se)
            "SSE" -> holder.idIDwindDirIMG.setImageResource(R.drawable.se)
            "S" -> holder.idIDwindDirIMG.setImageResource(R.drawable.s)
            "SSW" -> holder.idIDwindDirIMG.setImageResource(R.drawable.so)
            "SW" -> holder.idIDwindDirIMG.setImageResource(R.drawable.so)
            "WSW" -> holder.idIDwindDirIMG.setImageResource(R.drawable.so)
            "W" -> holder.idIDwindDirIMG.setImageResource(R.drawable.o)
            "WNW" -> holder.idIDwindDirIMG.setImageResource(R.drawable.ono)
            "NW" -> holder.idIDwindDirIMG.setImageResource(R.drawable.ono)
            "NNW" -> holder.idIDwindDirIMG.setImageResource(R.drawable.ono)
        }
    }

    override fun getItemCount() = users.size

    class ViewHolder(itemView: View): RecyclerView.ViewHolder(itemView) {
        val idIDconditionIcon: ImageView = itemView.findViewById(R.id.IDcondition_icon)
        val idIDconditionText: TextView = itemView.findViewById(R.id.IDcondition_text)
        val idIDhora: TextView = itemView.findViewById(R.id.IDhora)
        val idIDlluvia: TextView = itemView.findViewById(R.id.IDlluvia)
        val idIDhumidity: TextView = itemView.findViewById(R.id.IDhumidity)
        val idIDuv: TextView = itemView.findViewById(R.id.IDuv)
        val idIDtempC: TextView = itemView.findViewById(R.id.IDtemp_c)
        val idIDwindDir: TextView = itemView.findViewById(R.id.IDwind_dir)
        val idIDwindKph: TextView = itemView.findViewById(R.id.IDwind_kph)
        val idIDwindDirGrades: TextView = itemView.findViewById(R.id.IDwind_dirGrades)
        val idIDwindDirIMG: ImageView = itemView.findViewById(R.id.IDwind_dirIMG)
    }
}
