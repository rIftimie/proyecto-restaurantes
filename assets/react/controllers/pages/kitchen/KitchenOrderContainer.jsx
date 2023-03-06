import React from 'react';
import KitchenOrderCard from './KitchenOrderCard';

function KitchenOrderContainer({ useStateOrder }) {
	const orders = useStateOrder.orders;
	const renderOrders = orders?.map((order) => (
		<KitchenOrderCard
			order={order}
			useStateOrder={useStateOrder}
			key={order.id}
		/>
	));
	return (
		<main className="d-flex justify-content-between">{renderOrders}</main>
	);
}

export default KitchenOrderContainer;
