const ordersUrl = 'http://127.0.0.1:8000/orders';
const productsUrl = 'http://127.0.0.1:8000/api/products';
const menuUrl = 'http://127.0.0.1:8000/api/menu';

// POST: Termina un pedido: status 1 -> 2
export const finishOrder = async (order, user) => {
	try {
		const response = await fetch(`${ordersUrl}/kitchen/${order.id}/finish`, {
			method: 'POST',
			headers: { 'Content-Type': 'application/json; charset=utf-8' },
			body: JSON.stringify(user.id),
		});
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		return response;
	} catch (error) {
		console.error(error);
	}
};

// POST: Cancela un pedido: status -> 4
export const declineOrder = async (order, user) => {
	try {
		const response = await fetch(`${ordersUrl}/kitchen/${order.id}/decline`, {
			method: 'POST',
			headers: { 'Content-Type': 'application/json; charset=utf-8' },
			body: JSON.stringify(user.id),
		});
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		return response;
	} catch (error) {
		console.error(error);
	}
};

// GET: Trae el menu del restaurante del usuario
export const getMenu = async (restaurant) => {
	try {
		const response = await fetch(menuUrl, {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(restaurant),
		});

		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		const data = await response.json();
		return data;
	} catch (error) {
		console.log(error);
	}
};

// GET: Trae los productos de la cadena
export const getProducts = async () => {
	try {
		const response = await fetch(productsUrl);

		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		const data = await response.json();
		console.log(data);
		return data;
	} catch (error) {
		console.log(error);
	}
};

// PUT: Cambiar Stock producto
export const changeStockProduct = async (product, quantity) => {
	const qty = parseInt(quantity);

	if (qty > 0) {
		product.stock = parseInt(product.stock) + qty;
	} else if (qty < 0 && Math.abs(qty) <= product.stock) {
		product.stock = parseInt(product.stock) - Math.abs(qty);
	} else {
		// Si hay menos de lo que quieres quitar lo ponemos en 0
		product.stock = 0;
	}

	try {
		const response = await fetch(`${productsUrl}/change`, {
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
