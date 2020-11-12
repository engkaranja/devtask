/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package mpesaclient;
import javax.json.JsonObject;
import javax.ws.rs.*;
import javax.ws.rs.POST;
import javax.ws.rs.core.MediaType;
import org.json.JSONObject;

/**
 *
 * @author KARANJA
 */

@Path("mavuno")
public class Transactions {
    
    @POST
    @Path("mpesa")
    public static String receiveTransaction(String JsonRequest){
        
        
        JsonObject jObj  = new JsonObject(JsonRequest);
                   
    
        return "";
    }
    
}
