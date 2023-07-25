#include <SPI.h>
#include <Ethernet.h>
#include "DHT.h"

// DHT Sensor Setup
#define DHTPIN 7          // DHT Sensor attached to digital pin 7
#define DHTTYPE DHT22     // This is the type of DHT Sensor (Change it to DHT11 if you're using that model)
DHT dht(DHTPIN, DHTTYPE); // Initialize DHT object

// Ethernet & Server Setup
byte mac[] = {0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED};
byte ip[] = {192, 168, 1, 20}; // google will tell you: "public ip address"
char serverName[] = "sqweeb.net";

void startEthernet()
{
  Serial.println("... Initializing ethernet");
  if (Ethernet.begin(mac) == 0)
  {
    Serial.println("... Failed to configure Ethernet using DHCP");
    // no point in carrying on, so do nothing forevermore:
    // try to congifure using IP address instead of DHCP:
    Ethernet.begin(mac, ip);
  }
  Serial.println("... Done initializing ethernet");
}

void setup()
{
  Serial.begin(9600);

  Serial.println("... Initializing DHT");
  // startEthernet();
  dht.begin();
  delay(1000);
}

void printVals(float temp, float humidity)
{
  Serial.print("tf: ");
  Serial.print(temp);
  Serial.println("");
  Serial.print("h: ");
  Serial.print(humidity);
  Serial.println("");
}

void loop()
{
  EthernetClient client;
  float h, t, tf;

  bool force = false;
  bool fahrenheit = true;
  h = dht.readHumidity(force);
  tf = dht.readTemperature(fahrenheit, force);

  printVals(tf, h);

  if (client.connect(serverName, 80))
  {
    client.print("GET /dht/add.php?");
    client.print("tf=");
    client.print(tf);
    client.print("&");
    client.print("hum=");
    client.print(h);
    client.println(" HTTP/1.1");
    client.println("Host: localhost");
    client.println("Content-Type: application/x-www-form-urlencoded");
    client.println("Connection: close");
    client.println();
    client.println();
    client.stop();
  }
  delay(60000); // delay updates for 1 minute
}
