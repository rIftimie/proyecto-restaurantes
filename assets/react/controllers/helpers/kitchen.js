const url = 'http://127.0.0.1:8000/orders';
const url2 = 'http://127.0.0.1:8000/products';

// PUT: Termina un pedido: status 1 -> 2
export const finishOrder = async (order) => {
	try {
		const response = await fetch(`${url}/kitchen/${order.id}/finish`, {
			method: 'PUT',
			headers: { 'Content-Type': 'application/json; charset=utf-8' },
			body: JSON.stringify(order),
		});
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		return response;
	} catch (error) {
		console.error(error);
	}
};

// PUT: Cancela un pedido: status -> 4
export const declineOrder = async (order) => {
	try {
		const response = await fetch(`${url}/kitchen/${order.id}/decline`, {
			method: 'PUT',
			headers: { 'Content-Type': 'application/json; charset=utf-8' },
			body: JSON.stringify(order),
		});
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		return response;
	} catch (error) {
		console.error(error);
	}
};

// GET: Trae los productos
export const getProducts = async () => {
	try {
		const urlProducts = `http://127.0.0.1:8000/api/restaurant/products`;
		const response = await fetch(urlProducts);

		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		const data = await response.json();
		return data;
	} catch (error) {
		console.log(error);
	}
};

// PUT: Cambiar Stock producto
export const changeStockProduct = async (product, quantity) => {
	const qty = parseInt(quantity);
	let bool = true;
	if (qty > 0) {
		product.stock = parseInt(product.stock) + qty;
	} else if (qty < 0 && Math.abs(qty) <= product.stock) {
		product.stock = parseInt(product.stock) - Math.abs(qty);
	} else {
		// Si hay menos de lo que quieres quitar lo ponemos en 0
		product.stock = 0;
	}
	try {
		const response = await fetch(`${url2}/change`, {
			method: 'PUT',
			headers: { 'Content-Type': 'application/json; charset=utf-8' },
			body: JSON.stringify(product),
		});
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		return response;
	} catch (error) {
		console.error(error);
	}
};
