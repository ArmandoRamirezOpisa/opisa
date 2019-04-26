<%-- 
    Document   : index
    Created on : 28/06/2011, 05:47:37 PM
    Author     : AQUIM
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ page import="java.util.*" %>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JSP Page</title>
    </head>
    <body>
        <h1>Hola Mundo!</h1><br>
        <div>La hora es :
            <% 
                Date date = new Date();
                for(int x=0;x<10;x++)
                {
                    out.println("java="+x+date+"<br>");
                }
            %>
        </div>
    </body>
</html>