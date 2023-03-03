import { async } from "regenerator-runtime";

const url = 'http://127.0.0.1:8000/api/orders';
const url2= 'http://127.0.0.1:8000/orders';

export const getOrders = async () => {

    try {
        const response = await fetch(url);
        const data = await response.json();
        console.log(data);
        return data;
    } catch (error) {
        console.log(error);
    }
    
   
};

export const getOrder = async (order) => {
  
   try {
    const response = await fetch(`${url}/${order.id}`);
    const data = await response.json();
    return data;
   } catch (error) {
    console.log(error);
   }
   
  };

export const deleteOrder = async (order) => {
    try {
        
        const response = await fetch(`${url}/${order.id}`, {
        method: "DELETE",
        });

    
        return await response.json();
        
    } catch (error) {
        console.log(error);
    }

};

export const updateOrder = async (order) => {
    try {
    
        const response = await fetch(`${url}/${order.id}/edit`, {
        method: "PUT",
        headers: { "Content-Type": "application/json; charset=utf-8" },
        body: JSON.stringify(order),
        });

    
        return await response.json();
        
    } catch (error) {
        console.log(error);
    }
};

export const acceptOrder = async (order) => {
    try {
        const data = {};
        const response = await fetch(`${url2}/kitchen/${order.id}/accept`, {
        method: "PUT",
        headers: { "Content-Type": "application/json; charset=utf-8" },
        body: JSON.stringify(order),
        });

    
        return response;
        
    } catch (error) {
        console.log(error);
    }
};

export const finishOrder = async (order) => {
    try {
        const response = await fetch(`${url2}/kitchen/${order.id}/finish`,{
            method: "PUT",
            headers: { "Content-Type": "application/json; charset=utf-8" },
            body: JSON.stringify(order),
        });
        return response;
    } catch (error) {
        console.error(error);
    }
}

export const declineOrder = async (order) =>{
    try {
        const response = await fetch(`${url2}/kitchen/${order.id}/decline`,{
            method: "PUT",
            headers: { "Content-Type": "application/json; charset=utf-8" },
            body: JSON.stringify(order),
        });
        return response;
    } catch (error) {
        console.error(error);
    }
}