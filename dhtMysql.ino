#include <SPI.h>
#include <Ethernet.h>
#include "DHT.h"

// DHT Sensor Setup
#define DHTPIN 7 // DHT Sensor attached to digital pin 7
#define DHTTYPE DHT22 // This is the type of DHT Sensor (Change it to DHT11 if you're using that model)
DHT dht(DHTPIN, DHTTYPE); // Initialize DHT object

// Ethernet & Server Setup
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
byte ip[] = { 192, 168, 1, 20 }; // google will tell you: "public ip address"
char serverName[] = "sqweeb.net"; 

void startEthernet(){
    Serial.println("... Initializing ethernet");
    if(Ethernet.begin(mac) == 0)
      {
        Serial.println("... Failed to configure Ethernet using DHCP");
        // no point in carrying on, so do nothing forevermore:
        // try to congifure using IP address instead of DHCP:
        Ethernet.begin(mac, ip);
      }
    Serial.println("... Done initializing ethernet");
}

void setup() {
  Serial.begin( 9600 );
  startEthernet();
  dht.begin();
  delay(1000);
}

void loop() {
  EthernetClient client;
  float h, t, tf;
  
  if( client.connect(serverName, 80) ) 
    {
      h = dht.readHumidity();
      t = dht.readTemperature();
      tf = t*9/5+32;
      Serial.println(tf);
      Serial.println(h);
      client.print( "GET /dht/add.php?");
      client.print("tf=");
      client.print(tf);
      client.print("&");
      client.print("hum=");
      client.print(h);
      client.println( " HTTP/1.1");
      client.println( "Host: localhost" );
      client.println( "Content-Type: application/x-www-form-urlencoded" );
      client.println( "Connection: close" );
      client.println();
      client.println();
      client.stop();
    }
  delay(60000); //delay updates for 1 minute
}
