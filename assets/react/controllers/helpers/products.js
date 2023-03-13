const url = 'http://127.0.0.1:8000/api/restaurant/';

// GET: Devuelve todos los products de api/products
export const getProducts = async (idres) => {
	try {
		const response = await fetch(url + idres + '/menu');
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);
		const data = await response.json();
		return data;
	} catch (error) {
		console.log(error);
	}
};
