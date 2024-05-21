
  int buzzerPin = 11;
void setup() {
  // put your setup code here, to run once:

  pinMode(buzzerPin, OUTPUT);
  beep(50); //Beep
  beep(50); //Beep
  
}

void loop() {
  // put your main code here, to run repeatedly:
  beep(50); //Beep
  beep(50); //Beep
  delay(5000);
}

void beep(unsigned char delayms) { //creating function
  analogWrite(buzzerPin, 20); //Setting pin to high
  delay(delayms); //Delaying
  analogWrite(buzzerPin , 0); //Setting pin to LOW
  delay(delayms); //Delaying
}
