.. include:: /Includes.rst.txt

============================
DT3-PACE Documentation
============================

This is the starting point for the documentation of the dt3_pace extension.

Events
======

The extension dispatches several events that can be used by third-party
extensions:

* ``Ndrstmr\Dt3Pace\Event\AfterVoteAddedEvent`` – emitted after a ``Vote``
  entity has been persisted.
* ``Ndrstmr\Dt3Pace\Event\SessionStatusChangedEvent`` – emitted whenever a
  ``Session`` changes its status.
