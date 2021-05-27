import org.w3c.dom.Document;
import org.w3c.dom.Element;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.transform.OutputKeys;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerException;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;
import java.io.*;
import java.sql.*;
import java.util.Date;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.text.SimpleDateFormat;

public class DB_Utils{
    Connection con=null;
    Document doc = null;

    /**
     * Aquí fem la funció de connexió que el que fa és connectar-se a la base de dades
     * */
    public Connection coneccio(){
        try{
            Connection con= DriverManager.getConnection("jdbc:mysql://localhost:3306/banyantreeservice","banyantreeservice","1234");
            return con;
        }catch(Exception e){ System.out.println(e);}
        return null;
    }
    /**
     * Aquí fem la funció de execute que executa la query i crida les funcions aDocument i la funció de guardarDocument
     * */
    public void execute(String linia,int opcio){
        try {
             con =  coneccio();
            Statement x=con.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,ResultSet.CONCUR_UPDATABLE,ResultSet.CLOSE_CURSORS_AT_COMMIT);
            if(linia.startsWith("insert")||linia.startsWith("update")||linia.startsWith("delete")){
                x.executeUpdate(linia);
            }
            else {
                ResultSet rs = x.executeQuery(linia);
                 doc=aDocument(rs,opcio);
                guardarDocument(doc,opcio);
                rs.close();


            }
            desconeccio();
        }catch(Exception e){ System.out.println(e);}
    }

    /**
     * Aquí fem la funció de desconnexió que el que fa és tancar la connexió amb la base de dades
     * */
    public void desconeccio() throws SQLException {
        con.close();
    }

    /**
     * Aquí fem la funció aDocument que el que fa és assignar com un document xml amb el resultat de la query a la variable doc
     * */
    public static Document aDocument(ResultSet rs,int opcio) throws ParserConfigurationException, SQLException {
        DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
        DocumentBuilder builder        = factory.newDocumentBuilder();
        Document doc                   = builder.newDocument();
        Element resultat;
        if(opcio==0){
            resultat = doc.createElement("Productes");
        }
        else {
            resultat = doc.createElement("Comandes");
        }

        ResultSetMetaData rsmd = rs.getMetaData();
        int contadorColumna = rsmd.getColumnCount();
        if (opcio==0) {
            while (rs.next()) {
                Element linia = doc.createElement("Producte");
                Element linia2 = doc.createElement("Disponibilitat");
                for (int i = 1; i <= contadorColumna; i++) {
                    String nomColumna = rsmd.getColumnName(i);
                    Object valor = rs.getObject(i);
                    Element element = doc.createElement(nomColumna);
                    element.appendChild(doc.createTextNode(valor.toString()));
                    if (nomColumna.equals("quantitat_total") || nomColumna.equals("quantitat_venuda")) {
                        linia2.appendChild(element);
                    } else {
                        linia.appendChild(element);
                    }
                }
                linia.appendChild(linia2);
                resultat.appendChild(linia);

            }
        }
        else{
            String actual="";
            Element linia= doc.createElement("Comanda");
            Element linia2 = doc.createElement("Linies_Comanda");

            while (rs.next()) {
                if (!actual.equals(rs.getObject(1).toString())) {
                    linia= doc.createElement("Comanda");
                    linia2 = doc.createElement("Linies_Comanda");
                }

                Element linia3 = doc.createElement("Linia_comanda");
                for (int i = 1; i <= contadorColumna; i++) {
                    String nomColumna = rsmd.getColumnName(i);
                    Object valor = rs.getObject(i);
                    Element element = doc.createElement(nomColumna);
                    element.appendChild(doc.createTextNode(valor.toString()));
                    if (nomColumna.equals("id") || nomColumna.equals("name")) {
                        if (!actual.equals(rs.getObject(1).toString())) {
                            linia.appendChild(element);
                        }
                    } else {
                        linia3.appendChild(element);
                    }
                }
                linia2.appendChild(linia3);

                if (!actual.equals(rs.getObject(1).toString())) {
                    linia.appendChild(linia2);
                    resultat.appendChild(linia);
                }
                actual= rs.getObject(1).toString();


            }

        }
        doc.appendChild(resultat);

        return doc;
    }

    /**
     * Aquí fem una funció que el que fa és agafar el document creat anteriorment i després el guarda a la carpeta src amb el nom asignat.
     * */
    static void guardarDocument(Document doc, Integer opcio)
        throws IOException, TransformerException {
        String fileName;
        if (opcio==0){
            fileName= new SimpleDateFormat("yyyyMMddHHmm'-Porductes.xml'").format(new Date());
        }
        else {
            fileName= new SimpleDateFormat("yyyyMMddHHmm'-Comandes.xml'").format(new Date());
        }
        TransformerFactory factory = TransformerFactory.newInstance();
        Transformer transformer = factory.newTransformer();
        transformer.setOutputProperty(OutputKeys.ENCODING, "UTF-8");
        transformer.setOutputProperty(OutputKeys.METHOD, "xml");
        transformer.setOutputProperty(OutputKeys.OMIT_XML_DECLARATION, "no");
        transformer.setOutputProperty(OutputKeys.INDENT, "yes");
        transformer.setOutputProperty("{http://xml.apache.org/xslt}indent-amount", "4");

        transformer.transform(new DOMSource(doc),
            new StreamResult(new FileOutputStream(fileName)));

    }

}
