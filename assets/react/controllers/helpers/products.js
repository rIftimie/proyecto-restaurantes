const url = 'http://127.0.0.1:8000/api/restaurant/';
const url2 = 'http://127.0.0.1:8000/orders';

// GET: Devuelve todos los products de api/products
export const getProducts = async (idres) => {
	try {
		const response = await fetch(url+idres+'/products');
		if (!response.ok)
    throw new Error(response.status + ' ' + response.statusText);
    
		const data = await response.json();
		return data;
	} catch (error) {
		console.log(error);
	}
};

export const updateOrderProduct = async(idord, prod) => {
  try {
		const response = await fetch(`${url2}/${idord}/update`, {
			method: 'PUT',
			headers: { 'Content-Type': 'application/json; charset=utf-8' },
			body: JSON.stringify(prod),
		});
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);
		return response;
	} catch (error) {
		console.log(error);
	}
}