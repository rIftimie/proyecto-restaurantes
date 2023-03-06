import React from 'react';
import OrderWaiterCard from './OrderWaiterCard';

function OrderWaiterContainer({ useStateOrder }) {
	const orders = useStateOrder.orders.filter(
		(order) => order.status === 0 || order.status === 3
	);

	const renderOrders = orders.map((order) => (
		<OrderWaiterCard
			key={order.id}
			order={order}
			useStateOrder={useStateOrder}
		/>
	));

	return (
		<main className="d-flex justify-content-between">{renderOrders}</main>
	);
}

export default OrderWaiterContainer;
