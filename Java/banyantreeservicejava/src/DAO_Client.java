public class DAO_Client {
        DB_Utils coneccio=new DB_Utils();

        /**
         * Aquí fem una funció que el que fa és cridar a la funció execute de la classe DB_UTILS amb la query per agafar tots els productes actius
         * i l'opció (si és 0 és per un arxiu xml amb productes si és 1 és per un arxiu xml amb comandes)
         * */
        public void getAllProductesActius(){
            coneccio.execute("SELECT productes.*,disponibles.quantitat_total,disponibles.quantitat_venuda FROM `productes` left join disponibles on productes.id = disponibles.producte_id WHERE productes.eliminat=0 GROUP BY productes.id HAVING disponibles.quantitat_total>=disponibles.quantitat_venuda ORDER BY productes.preu",0);
        }

        /**
         * Aquí fem una funció que el que fa és cridar a la funció execute de la classe DB_UTILS amb la query per agafar totes les comandes entregades
         * i l'opció (si és 0 és per un arxiu xml amb productes si és 1 és per un arxiu xml amb comandes)
         * */
        public void getComandesEntregades(){
            coneccio.execute("SELECT comandas.id,users.name, comanda_linias.producte_nom,comanda_linias.producte_descripcio,comanda_linias.producte_mides,comanda_linias.producte_preu,comanda_linias.quantitat,comanda_linias.unitat,comanda_linias.producte_id FROM `comandas` left join users on users.id=comandas.user_id left join comanda_linias on comandas.id = comanda_linias.comanda_id WHERE comandas.estat=2 ORDER BY comandas.id",1);
        }

}
