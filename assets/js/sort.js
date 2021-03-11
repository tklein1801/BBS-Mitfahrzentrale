class Sort {
  oldToNew(data) {
    var temp = data;
    temp.sort((a, b) => {
      if (parseInt(a.createdAt) > parseInt(b.createdAt)) {
        return 1;
      }
      if (parseInt(a.createdAt) < parseInt(b.createdAt)) {
        return -1;
      }
      return 0;
    });
    return temp;
  }

  newToOld(data) {
    var temp = data;
    temp.sort((a, b) => {
      if (parseInt(b.createdAt) > parseInt(a.createdAt)) {
        return 1;
      }
      if (parseInt(b.createdAt) < parseInt(a.createdAt)) {
        return -1;
      }
      return 0;
    });
    return temp;
  }

  cheapToMostExpensive(data) {
    var temp = data;
    temp.sort((a, b) => {
      if (parseInt(a.price) > parseInt(b.price)) {
        return 1;
      }
      if (parseInt(a.price) < parseInt(b.price)) {
        return -1;
      }
      return 0;
    });
    return temp;
  }

  mostExpensiveToCheap(data) {
    var temp = data;
    temp.sort((a, b) => {
      if (parseInt(b.price) > parseInt(a.price)) {
        return 1;
      }
      if (parseInt(b.price) < parseInt(a.price)) {
        return -1;
      }
      return 0;
    });
    return temp;
  }

  seatsAsc(data) {
    var temp = data;
    temp.sort((a, b) => {
      if (parseInt(a.seats) > parseInt(b.seats)) {
        return 1;
      }
      if (parseInt(a.seats) < parseInt(b.seats)) {
        return -1;
      }
      return 0;
    });
    return temp;
  }

  seatsDesc(data) {
    var temp = data;
    temp.sort((a, b) => {
      if (parseInt(b.seats) > parseInt(a.seats)) {
        return 1;
      }
      if (parseInt(b.seats) < parseInt(a.seats)) {
        return -1;
      }
      return 0;
    });
    return temp;
  }
}
