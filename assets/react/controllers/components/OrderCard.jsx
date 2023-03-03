import React from "react";

function OrderCard({order}) {

 

  const orderStatus = order.status;
  console.log(orderStatus);
  const classes = ["card text-light d-flex"];

  if(orderStatus==0){
    classes.push("bg-warning");
  }else if(orderStatus==1){
    classes.push("bg-success")
  }else if(orderStatus==2){
    classes.push("bg-warning")
  }else if(orderStatus==3){
    classes.push("bg-primary")
  }
 
  return (
   
      <section className={classes.join(" ")}  style={{ textAlign: "center" }}>
        <div className="card-body">
          <p>Camarero:{order.waiter}</p>
          <h5 className="card-title">Estado del pedido:{order.status==0 ? "En camino":"Finalizado"}</h5>
          <h6>Fecha:{order.orderDate.date}</h6>
          
        </div>
      </section>
   
  );
}

export default OrderCard;
