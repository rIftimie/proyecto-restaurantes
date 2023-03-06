const url = 'http://127.0.0.1:8000/orders/paid';
export const payOrder2 = async (data) => {
  try {
      const response = await fetch(url, {
        method: "POST",
        headers: { 
          "Content-Type": "application/json; charset=utf-8",},
        body: JSON.stringify(data),
      });
      return await response;
      
  } catch (error) {
      console.log(error);
  }
};