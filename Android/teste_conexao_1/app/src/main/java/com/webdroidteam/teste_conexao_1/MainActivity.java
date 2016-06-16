package com.webdroidteam.teste_conexao_1;

import android.content.ActivityNotFoundException;
import android.content.ComponentName;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.net.wifi.WifiManager;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Toast;

import com.google.android.gms.appindexing.Action;
import com.google.android.gms.appindexing.AppIndex;
import com.google.android.gms.common.api.GoogleApiClient;

import java.lang.reflect.Field;
import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;

public class MainActivity extends AppCompatActivity {
    WifiManager adminWifi;
    /**
     * ATTENTION: This was auto-generated to implement the App Indexing API.
     * See https://g.co/AppIndexing/AndroidStudio for more information.
     */
    private GoogleApiClient client;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);


        adminWifi = (WifiManager) MainActivity.this.getSystemService(Context.WIFI_SERVICE);

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client = new GoogleApiClient.Builder(this).addApi(AppIndex.API).build();
    }

    public void testaCon(View view) {
        if (isOnline(MainActivity.this)) {
            Toast.makeText(MainActivity.this, "Conexão OK", Toast.LENGTH_LONG).show();

        } else {
            Toast.makeText(MainActivity.this, "Sem Conexão", Toast.LENGTH_LONG).show();
        }
    }

    public void ligaWifi(View view) {
        if (!isOnline(this)) {
            alertDialog(this);
        }
        //setEstadoWifi();
    }

    public void testeMobile(View view) throws ClassNotFoundException, NoSuchMethodException, NoSuchFieldException, IllegalAccessException, InvocationTargetException {
        if (testa3G(this)) {
            Toast.makeText(this, "3G LIGADA", Toast.LENGTH_LONG).show();
        } else {
            Toast.makeText(this, "3G DESLIGADA", Toast.LENGTH_LONG).show();
            setMobileDataEnabled(MainActivity.this, true);
        }
    }

    public void setEstadoWifi() {
        if (adminWifi.isWifiEnabled()) {
            //Toast.makeText(MainActivity.this, "WIFI LIGADA", Toast.LENGTH_LONG).show();
            adminWifi.setWifiEnabled(false);
            //Toast.makeText(MainActivity.this, "WIFI foi desligada", Toast.LENGTH_LONG).show();
        } else {
            //Toast.makeText(MainActivity.this, "WIFI DESLIGADA", Toast.LENGTH_LONG).show();
            adminWifi.setWifiEnabled(true);
            //Toast.makeText(MainActivity.this, "WIFI foi ligada", Toast.LENGTH_LONG).show();
        }


    }

    public static boolean isOnline(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo netInfo = cm.getActiveNetworkInfo();
        if (netInfo != null && netInfo.isConnected())
            return true;
        else
            return false;
    }

    public boolean testa3G(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);

        NetworkInfo mobile = cm.getNetworkInfo(ConnectivityManager.TYPE_MOBILE);

        return mobile.isConnected();


    }

    public void alertDialog(final Context context) {
        try {
            AlertDialog.Builder alerta = new AlertDialog.Builder(context);
            //alerta.setIcon(R.drawable.abc_ic_go);
            alerta.setTitle("Alerta");
            alerta.setMessage("Sinal não encontrado.");

            alerta.setPositiveButton("Ativar Wifi?", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialogInterface, int i) {
                    //Toast.makeText(context, "Sinal não encontrado. Aplicação será encerrada", Toast.LENGTH_LONG).show();
                    setEstadoWifi();
                }
            });

            alerta.show();
        } catch (Exception erro) {
            Log.e("Erro: ", erro.getMessage(), erro);
        }
    }

    @Override
    public void onStart() {
        super.onStart();

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client.connect();
        Action viewAction = Action.newAction(
                Action.TYPE_VIEW, // TODO: choose an action type.
                "Main Page", // TODO: Define a title for the content shown.
                // TODO: If you have web page content that matches this app activity's content,
                // make sure this auto-generated web page URL is correct.
                // Otherwise, set the URL to null.
                Uri.parse("http://host/path"),
                // TODO: Make sure this auto-generated app URL is correct.
                Uri.parse("android-app://com.webdroidteam.teste_conexao_1/http/host/path")
        );
        AppIndex.AppIndexApi.start(client, viewAction);
    }

    @Override
    public void onStop() {
        super.onStop();

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        Action viewAction = Action.newAction(
                Action.TYPE_VIEW, // TODO: choose an action type.
                "Main Page", // TODO: Define a title for the content shown.
                // TODO: If you have web page content that matches this app activity's content,
                // make sure this auto-generated web page URL is correct.
                // Otherwise, set the URL to null.
                Uri.parse("http://host/path"),
                // TODO: Make sure this auto-generated app URL is correct.
                Uri.parse("android-app://com.webdroidteam.teste_conexao_1/http/host/path")
        );
        AppIndex.AppIndexApi.end(client, viewAction);
        client.disconnect();
    }

    private void setMobileDataEnabled(Context context, boolean enabled) throws InvocationTargetException, IllegalAccessException, NoSuchMethodException, ClassNotFoundException, NoSuchFieldException {
        final ConnectivityManager conman = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        final Class conmanClass = Class.forName(conman.getClass().getName());
        final Field iConnectivityManagerField = conmanClass.getDeclaredField("mService");
        iConnectivityManagerField.setAccessible(true);
        final Object iConnectivityManager = iConnectivityManagerField.get(conman);
        final Class iConnectivityManagerClass = Class.forName(iConnectivityManager.getClass().getName());
        final Method setMobileDataEnabledMethod = iConnectivityManagerClass.getDeclaredMethod("setMobileDataEnabled", Boolean.TYPE);
        setMobileDataEnabledMethod.setAccessible(true);

        setMobileDataEnabledMethod.invoke(iConnectivityManager, enabled);
    }
}
