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

Database Indexes
================

Several database indexes improve lookup performance. If you use Doctrine
migrations, they can be created automatically. Alternatively run the following
SQL statements after installing the extension::

    CREATE INDEX idx_session_status ON tx_dt3pace_domain_model_session (status);
    CREATE INDEX idx_session_time_slot ON tx_dt3pace_domain_model_session (time_slot);
    CREATE INDEX idx_session_room ON tx_dt3pace_domain_model_session (room);
    CREATE INDEX idx_vote_voter ON tx_dt3pace_domain_model_vote (voter);
    CREATE INDEX idx_vote_session ON tx_dt3pace_domain_model_vote (session);

When using Doctrine migrations call ``bin/typo3cms doctrine:migrations:diff``
after updating the entities and apply the generated migration.
