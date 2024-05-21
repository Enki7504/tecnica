#include <SPI.h>
#include <Ethernet.h>

byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
byte ip[] = {192, 168, 1, 18 }; //Enter the IP of ethernet shield
int    HTTP_PORT   = 80;
String HTTP_METHOD = "GET";
char   HOST_NAME[] = "192.168.1.135"; // change to your PC's IP address
String PATH_NAME   = "/proyecto/data.php";
String queryString = "?huella=";
String temp = "22";
EthernetClient cliente;
void setup() {
  Serial.begin(9600); //setting th|e baud rate at 9600
  Ethernet.begin(mac, ip);
}
void loop() {
  delay (1000);
  if (cliente.connect(HOST_NAME, 80)) { //Connecting at the IP address and port we saved before
    Serial.println("connected");
    
    cliente.println(HTTP_METHOD + " " + PATH_NAME + queryString + temp +" HTTP/1.1");
    cliente.println("Host: " + String(HOST_NAME));
    cliente.println("Connection: close");
    cliente.println();
    
    cliente.stop(); //Closing the connection
    
  }
  else {
    // if you didn't get a connection to the server:
    Serial.println("connection failed");
  }
  delay(4000);
}
