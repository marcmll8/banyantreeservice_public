
import java.util.Scanner;

public class Main {

    public static void main(String[] args) {
        Scanner a=new Scanner(System.in);
        DAO_Client coneccio=new DAO_Client();
        System.out.println("Entra la opcio que vols realitzar: \n 1: Mostrar tots els productes actius " +
            "\n 2: Mostrar totes les comandes que encara no estan preparades ni entregades\n 0: Per sortir");

        int i=a.nextInt();
        //Aquí fem un while que no sortirà fins que l'usuari entri 0.
        while (i!=0) {
            //Aquí fem un switch que segons l'opció que seleccioni farà una funció o un altre de la classe DAO_Client
            switch (i) {
                case (1):
                    coneccio.getAllProductesActius();
                    break;
                case (2):
                    coneccio.getComandesEntregades();
                    break;
            }
            System.out.println("Entra la opcio que vols realitzar: \n 1: Mostrar tots els productes actius \n 2: " +
                "Mostrar totes les comandes que encara no estan preparades ni entregades\n 0: Per sortir");
            i=a.nextInt();
        }
    }
}


