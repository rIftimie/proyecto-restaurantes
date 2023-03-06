import React from "react";

function KitchenOrderCard({ order, onHandleAccept, onHandleFinish, onHandleDecline }) {
  const orderStatus = order.status;
  const classes = ["card text-light d-flex"];

  if (orderStatus == 0) {
    classes.push("bg-warning");
  } else if (orderStatus == 1) {
    classes.push("bg-success");
  } else if (orderStatus == 2) {
    classes.push("bg-warning");
  } else if (orderStatus == 3) {
    classes.push("bg-primary");
  }

  return (
    <>
   <section className={classes.join(" ")} style={{ textAlign: "center" }}>
      <div className="card-body">
        <p>Camarero:{order.waiter}</p>
        <h5 className="card-title">
          Estado del pedido:
          {order.status == 1 ? "En confirmación" : "Trabajando"}
        </h5>
        <h6>Fecha:{order.orderDate.date}</h6>

        {order.status == 1 ? ( // Pagado
          <button onClick={()=>onHandleAccept(order)} className="btn btn-primary">Aceptar orden</button>
        ) : (
          // En Proceso
          <>
            <button onClick={()=>onHandleFinish(order)} className="btn btn-primary">Terminar orden</button>
            <button onClick={()=>onHandleDecline(order)} className="btn btn-primary">Cancelar orden</button>
          </>
        )}
      </div>
    </section>
    </>

  );
}

export default KitchenOrderCard;